<?php

namespace Bidaea\OutMart\Modules\Baskets\Enums;

enum Status: int
{
    case OPENED = 1;
    case ABANDONED = 2;
    case ORDERED = 3;
}
