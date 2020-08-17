<?php

namespace App\Model\Currency;

interface CurrencyInterface
{
    public function id(): Id;

    public function name(): Name;

    public function value(): float;
}
