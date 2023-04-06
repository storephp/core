<?php

namespace Basketin\Contracts\Model;

interface IFinalPrice
{
    public function getFinalPriceAttribute(): float;
}
