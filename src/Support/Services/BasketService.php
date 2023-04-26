<?php

namespace Basketin\Support\Services;

use Basketin\Contracts\ICondition;
use Basketin\Contracts\Model\IFinalPrice;
use Basketin\Enums\Baskets\Status;
use Basketin\Exceptions\Baskets\QuoteExceedingLimitException;
use Basketin\Exceptions\Baskets\QuoteTheMaxException;
use Basketin\Models\Basket\Coupon;
use Basketin\Models\Basket\Quote;
use Basketin\Support\Repositories\BasketRepository;
use Basketin\Support\Repositories\QuoteRepository;
use Exception;
use OutMart\PricingRules\Lay;

class BasketService
{
    private $currentBasket = null;
    private $currency = null;
    private $shippingMethod = null;
    private $paymentMethod = null;
    private $shippingTotal = null;
    private $taxTotal = null;
    private $discountTotal = null;

    public function __construct(
        private BasketRepository $basketRepository,
        private QuoteRepository $quoteRepository,
    ) {}

    /**
     * Basket init for enabled the use
     *
     * @param ulid $ulid
     * @param string $currency
     *
     * @return \Basketin\Support\Services\BasketService
     */
    public function initBasket($ulid = null, string $currency = 'EGP')
    {
        $basket = $this->basketRepository->getAvailableBasket($ulid);

        // dd($ulid, $basket);

        if (!$basket) {
            $basket = $this->basketRepository->createNewBasket($currency);
        }

        $this->currentBasket = $basket;
        $this->setCurrency($basket->currency);
        $this->quoteRepository->setBasket($basket);

        return $this;
    }

    /**
     * Get the value of currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of shippingMethod
     */
    public function getShippingMethod()
    {
        return $this->shippingMethod;
    }

    /**
     * Set the value of shippingMethod
     *
     * @return  self
     */
    public function setShippingMethod($shippingMethod)
    {
        $this->shippingMethod = $shippingMethod;

        return $this;
    }

    /**
     * Get the value of paymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Set the value of paymentMethod
     *
     * @return  self
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * Get the value of shippingTotal
     */
    public function getShippingTotal()
    {
        return $this->shippingTotal;
    }

    /**
     * Set the value of shippingTotal
     *
     * @return  self
     */
    public function setShippingTotal($shippingTotal)
    {
        $this->shippingTotal = $shippingTotal;

        return $this;
    }

    /**
     * Get the value of taxTotal
     */
    public function getTaxTotal()
    {
        return $this->taxTotal;
    }

    /**
     * Set the value of taxTotal
     *
     * @return  self
     */
    public function setTaxTotal($taxTotal)
    {
        $this->taxTotal = $taxTotal;

        return $this;
    }

    /**
     * Get the value of discountTotal
     */
    public function getDiscountTotal()
    {
        return $this->discountTotal;
    }

    /**
     * Set the value of discountTotal
     *
     * @return  self
     */
    public function setDiscountTotal($discountTotal)
    {
        $this->discountTotal = $discountTotal;

        return $this;
    }

    public function getId()
    {
        return $this->currentBasket->id;
    }

    public function getUlid()
    {
        return $this->currentBasket->ulid;
    }

    public function getStatus()
    {
        return $this->currentBasket->status;
    }

    public function addQuotes($productSku, int $quantity = 1)
    {
        $quote = $this->quoteRepository->getQuoteByProductSku($productSku);

        if (!$quote) {
            return $this->quoteRepository->create([
                'basket_id' => $this->currentBasket->id,
                'product_sku' => $productSku,
                'quantity' => $quantity,
            ]);
        }

        return $this->quoteRepository->increase($quote, $quantity);
    }

    public function getQuotes()
    {
        return $this->quoteRepository->getList();
    }

    public function increase(Quote $quote, int $quantity)
    {
        if ($quote->quantity >= config('basketin.baskets.max_quote')) {
            throw new QuoteTheMaxException();
        }

        return $this->quoteRepository->increase($quote, $quantity);
    }

    public function decrease(Quote $quote, int $quantity)
    {
        if ($quote->quantity <= $quantity) {
            $this->quoteRepository->delete($quote);
            return false;
        }

        if ($quantity < $quantity) {
            throw new QuoteExceedingLimitException();
        }

        return $this->quoteRepository->decrease($quote, $quantity);
    }

    public function deleteQuote(Quote $quote)
    {
        $this->quoteRepository->delete($quote);
    }

    public function applyCoupon($coupon)
    {
        if ($coupon = Coupon::where('coupon_code', $coupon)->first()) {
            $this->currentBasket->coupon_code = $coupon->coupon_code;
            $this->currentBasket->save();
        }
    }

    public function resetCoupon()
    {
        if ($this->currentBasket->coupon_code) {
            $this->currentBasket->coupon_code = null;
            $this->currentBasket->save();
        }
    }

    public function getCoupon()
    {
        return $this->currentBasket->coupon ?? null;
    }

    public function getSubTotal()
    {
        $quotes = $this->currentBasket->quotes()->with('product')->get();

        $subTotal = 0;

        if ($quotes) {
            foreach ($quotes as $quote) {
                if (!$quote->product instanceof IFinalPrice) {
                    throw new Exception("You must implement `\Basketin\Contracts\Model\IFinalPrice`");
                }

                $subTotal += $quote->quantity * $quote->product?->final_price;
            }
        }

        $lay = new Lay;
        $lay->setTotal($subTotal);

        if (($coupon = $this->getCoupon()) && (!$this->getCoupon()->expired)) {

            $lay->rule(function ($attributes) use ($coupon) {

                if ($coupon->condition) {
                    $conditionObj = config('basketin.coupons.conditions.' . $coupon->condition, null);
                    if ($conditionObj) {
                        $condition = new $conditionObj(
                            $attributes['total'],
                            $this->quotes()->pluck('product_sku')->toArray(),
                            $coupon->condition_data,
                        );

                        if (!$condition instanceof ICondition) {
                            throw new Exception('You need to implement `ICondition` in condition class');
                        }

                        return $condition->handle();
                    }
                    return false;
                }

                return true;
            }, function ($operations) use ($coupon) {
                $total = $operations->getTotal();

                if ($coupon->discount_type == 'percentage') {
                    $discount = ($total * $coupon->discount_value) / 100;
                    $total = $total - $discount;
                }

                if ($coupon->discount_type == 'fixed') {
                    $total = $total - $coupon->discount_value;
                }

                $operations->setTotal($total);
            });
        }

        $this->setDiscountTotal($subTotal - $lay->getTotal());

        return $subTotal;
    }

    public function getTotal(): float
    {
        $discountTotal = ($this->getSubTotal() - $this->getDiscountTotal());
        $feedsTotal = ($this->getShippingTotal() + $this->getTaxTotal());
        return ($discountTotal + $feedsTotal);
    }

    public function canUpdateStatus()
    {
        return in_array($this->currentBasket->status, [Status::OPENED(), Status::ABANDONED()]);
    }

    public function canPlaceOrder()
    {
        return $this->quoteRepository->basketHasQuote() && in_array($this->currentBasket->status, [Status::OPENED(), Status::ABANDONED()]);
    }

    public function prefaceOrder($key = null)
    {
        $data = [
            'basket' => $this->currentBasket,
            'sub_total' => $this->getSubTotal(),
            'discount_total' => $this->getDiscountTotal(),
            'shipping_total' => $this->getShippingTotal(),
            'tax_total' => $this->getTaxTotal(),
            'grand_total' => $this->getTotal(),
        ];

        if ($key && isset($data[$key])) {
            return $data[$key];
        }

        return $data;
    }
}
