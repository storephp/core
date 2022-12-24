<?php

namespace OutMart\Enums\Baskets;

enum Status: int
{
    case OPENED = 1;
    case ABANDONED = 2;
    case ORDERED = 3;
}
