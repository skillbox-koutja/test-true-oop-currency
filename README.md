Логика получения курсов валют следующая. 
Вызывающий код может получить их из кеша, из базы данных и из внешнего источника по http. 
В случае, если курса валют нет в кеше, надо проверить базу, и если там есть, положить в кеш. 
Если в базе нет -- проверить внешний источник и положить и в базу, и в кеш.
Надо реализовать эту логику. Предполагается, что она будет использоваться в куче разных мест.

Пример вызова кода

~~~php
<?php

use App\Model\Currency;

$id = new Currency\Id('...');
$httpClient = '...';
$connection = '...';
$cacheClient = '...';
$cacheStorage = new Currency\Cache\Storage();
$databaseStorage = new Currency\Database\Storage();
try {
    $currency = (
    new Currency\CurrencyFactory(
        $id,
        $cacheStorage,
        $databaseStorage,
        $httpClient,
        $connection,
        $cacheClient
    )
    )
        ->checkInCache()
        ->checkInDatabase()
        ->checkInHttp()
        ->create();
} catch (\App\Model\EntityNotExistException $e) {
    // обработка исключительной ситуации, когда найти курс валют не удалось
}

~~~
