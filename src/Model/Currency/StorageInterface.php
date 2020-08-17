<?php

namespace App\Model\Currency;

interface StorageInterface
{
    public function save(Currency $currency): void;
}
