<?php

namespace Bidaea\OutMart\Modules\Baskets\Enums;

enum Status: int
{
    case opened = 1;
    case abandoned = 2;
    case ordered = 3;
}
