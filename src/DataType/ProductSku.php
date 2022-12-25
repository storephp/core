<?php

namespace OutMart\DataType;

class ProductSku
{
    public $value;

    public function __construct($productSku)
    {
        return $this->value = $productSku;
    }

    public function __toString()
    {
        return $this->value;
    }
}
