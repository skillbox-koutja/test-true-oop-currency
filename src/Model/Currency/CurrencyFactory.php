<?php

namespace App\Model\Currency;

use App\Model\EntityNotExistException;

class CurrencyFactory
{
    /** @var AbstractExistedCurrency[] */
    private $id;
    /** @var AbstractExistedCurrency[] */
    private $currencies;
    /** @var Cache\Storage */
    private $cacheStorage;
    /** @var Database\Storage */
    private $databaseStorage;
    private $httpClient;
    private $connection;
    private $cacheClient;

    public function __construct(
        Id $id,
        Cache\Storage $cacheStorage,
        Database\Storage $databaseStorage,
        $httpClient,
        $connection,
        $cacheClient
    ) {
        $this->id = $id;
        $this->cacheStorage = $cacheStorage;
        $this->databaseStorage = $databaseStorage;
        $this->httpClient = $httpClient;
        $this->connection = $connection;
        $this->cacheClient = $cacheClient;
    }

    public function checkInCache(): self {

        $this->currencies[] = new Cache\Currency(
            $this->id,
            $this->cacheClient
        );
        return $this;
    }

    public function checkInDatabase(): self
    {
        $this->currencies[] = new Database\Currency(
            $this->id,
            [
                $this->cacheStorage,
            ],
            $this->httpClient
        );
        return $this;
    }

    public function checkInHttp(): self
    {
        $this->currencies[] = new Http\Currency(
            $this->id,
            [
                $this->databaseStorage,
                $this->cacheStorage,
            ],
            $this->httpClient
        );
        return $this;
    }

    public function create(): Currency
    {
        foreach ($this->currencies as $currency) {
            if ($currency->isExisted()) {
                return $currency;
            }
        }

        throw new EntityNotExistException('Currency doesn\'t exist');
    }
}
