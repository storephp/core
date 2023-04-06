<?php

namespace Basketin\Contracts;

interface ICondition
{
    public function handle(): bool;
}
