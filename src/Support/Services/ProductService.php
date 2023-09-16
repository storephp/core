<?php

namespace Store\Support\Services;

use Store\Exceptions\Products\ProductAlreadyExistsException;
use Store\Events\Products\ProductCreatedEvent;
use Store\Exceptions\Products\ProductAlreadyNotException;
use Store\Support\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $productRepository,
    ) {
    }

    public function create(array $data)
    {
        if ($this->productRepository->getBySku($data['sku'])) {
            throw new ProductAlreadyExistsException;
        }

        config([
            'store.catalog.products.external_fillable_entry' => array_merge(
                collect(array_keys($data))->diff(['sku'])->all(),
                config('store.catalog.products.external_fillable_entry', [])
            ),
        ]);

        $productModel = config('store.catalog.products.model');
        $model = new $productModel;

        $collection = collect($data);
        $fillable = $collection->only($model->getFillable())->all();
        $fillableEntities = $collection->only($model->fillableEntities())->all();

        $productCreated = $this->productRepository->create($fillable, $fillableEntities);

        ProductCreatedEvent::dispatch($productCreated, array_merge($fillable, $fillableEntities));

        return $productCreated;
    }

    public function getById($value)
    {
        if (!$product = $this->productRepository->getById($value)) {
            throw new ProductAlreadyNotException;
        }

        return $product;
    }

    public function getBySku($value)
    {
        if (!$product = $this->productRepository->getBySku($value)) {
            throw new ProductAlreadyNotException;
        }

        return $product;
    }


    public function list($where = null)
    {
        return $this->productRepository->all($where);
    }
}
