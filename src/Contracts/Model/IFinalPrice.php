<?php

namespace Store\Contracts\Model;

interface IFinalPrice
{
    public function getFinalPriceAttribute(): float;
}
