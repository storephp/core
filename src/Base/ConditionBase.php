<?php

namespace OutMart\Base;

abstract class ConditionBase
{
    public function __construct(
        public $total,
        public $skus,
        public $condition_data,
    ) {
    }

    public function hasSku($sku)
    {
        return in_array($sku, $this->skus);
    }

    /**
     * Get the value of condition_data
     */
    public function getConditionData()
    {
        return $this->condition_data;
    }
}
