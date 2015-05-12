<?php

namespace Expressly\Entity;

class Order extends ArraySerializeable
{
    protected $amount;
    protected $currency;
    protected $lastOrder;
    protected $numberOrdered;

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = (double)$amount;

        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function getLastOrder()
    {
        return $this->lastOrder->getTimeStamp();
    }

    public function setLastOrder(\DateTime $lastOrder)
    {
        $this->lastOrder = $lastOrder;

        return $this;
    }

    public function getNumberOrdered()
    {
        return $this->numberOrdered;
    }

    public function setNumberOrdered($numberOrdered)
    {
        $this->numberOrdered = (int)$numberOrdered;

        return $this;
    }
}