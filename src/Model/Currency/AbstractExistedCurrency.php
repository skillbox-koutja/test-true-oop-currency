<?php

namespace App\Model\Currency;

abstract class AbstractExistedCurrency extends Currency
{
    abstract public function isExisted(): bool;
}
