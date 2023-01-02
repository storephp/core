<?php

namespace OutMart\Contracts;

interface ICondition
{
    public function handle(): bool;
}
