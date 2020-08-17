<?php

namespace App\Model\Currency\Database;

use App\Model\Currency\AbstractExistedCurrency;
use App\Model\Currency\Id;
use App\Model\Currency\Name;
use App\Model\Currency\StorageInterface;

class Currency extends AbstractExistedCurrency
{
    private $connection;

    /** @var StorageInterface[] */
    private $storages;

    public function __construct(Id $id, iterable $storages, $connection)
    {
        $this->_id = $id;
        $this->storages = $storages;
        $this->connection = $connection;
    }

    public function isExisted(): bool
    {
        $cnt = $this->connection->execute('select count(*) from ... where id = ?')
            ->bind([$this->id()->value()])
            ->fetchColumn();
        if ($cnt === 0) {
            return false;
        }
        $data = $this->connection->execute('select name, val from ... where id = ?')
            ->bind([$this->id()->value()])
            ->fetchAssoc();
        $this->_name = new Name($data['value']);
        $this->_value = $data['value'];

        foreach ($this->storages as $storage) {
            $storage->save($this);
        }

        return true;
    }
}
