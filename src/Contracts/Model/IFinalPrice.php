<?php

namespace OutMart\Contracts\Model;

interface IFinalPrice
{
    public function getFinalPriceAttribute(): float;
}
