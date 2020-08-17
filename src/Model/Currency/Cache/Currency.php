<?php

namespace App\Model\Currency\Cache;

use App\Model\Currency\AbstractExistedCurrency;
use App\Model\Currency\Id;
use App\Model\Currency\Name;

class Currency extends AbstractExistedCurrency
{
    private $cacheClient;

    public function __construct(Id $id, $cacheClient)
    {
        $this->_id = $id;
        $this->cacheClient = $cacheClient;
    }

    public function isExisted(): bool
    {
        $tag = "currency.{$this->id()->value()}";
        if (!$this->cacheClient->isHit($tag)) {
            return false;
        }
        $data = $this->cacheClient->get($tag);

        $this->_name = new Name($data['name']);
        $this->_value = $data['value'];

        return true;
    }
}

