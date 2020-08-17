<?php

namespace App\Model\Currency\Http;

use App\Model\Currency\AbstractExistedCurrency;
use App\Model\Currency\Id;
use App\Model\Currency\Name;
use App\Model\Currency\StorageInterface;

class Currency extends AbstractExistedCurrency
{
    private $httpClient;

    /** @var StorageInterface[] */
    private $storages;

    public function __construct(Id $id, iterable $storages, $httpClient)
    {
        $this->_id = $id;
        $this->storages = $storages;
        $this->httpClient = $httpClient;
    }

    public function isExisted(): bool
    {
        $response = $this->httpClient->request(['id' => $this->id()]);
        $data = json_decode($response->json(), true);
        if (empty($data)) {
            return false;
        }

        $this->_name = new Name($data['name']);
        $this->_value = $data['value'];

        foreach ($this->storages as $storage) {
            $storage->save($this);
        }

        return true;
    }
}
