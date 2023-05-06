<?php

namespace Store\Contracts;

interface ICondition
{
    public function handle(): bool;
}
