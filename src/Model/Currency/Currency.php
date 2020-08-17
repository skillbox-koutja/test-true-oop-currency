<?php

namespace App\Model\Currency;

class Currency implements CurrencyInterface
{
    /** @var Id */
    protected $_id;

    /** @var Name */
    protected $_name;

    /** @var float */
    protected $_value;

    public function __construct(
        Id $id,
        Name $name,
        float $value
    )
    {
        $this->_id = $id;
        $this->_name = $name;
        $this->_value = $value;
    }

    public function id(): Id
    {
        return $this->_id;
    }

    public function name(): Name
    {
        return $this->_name;
    }

    public function value(): float
    {
        return $this->_value;
    }
}
