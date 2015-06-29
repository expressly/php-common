<?php

namespace Expressly\Entity;

class Order extends ArraySerializeable
{
    protected $id;
    protected $date;
    protected $itemCount;
    protected $coupon;
    protected $currency;
    protected $preTaxTotal;
    protected $postTaxTotal;
    protected $tax;

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setDate(\DateTime $date)
    {
        $date->setTimezone(new \DateTimeZone('UTC'));
        $this->date = $date->format(\DateTime::ISO8601);

        return $this;
    }

    public function setItemCount($itemCount)
    {
        $this->itemCount = (int)$itemCount;

        return $this;
    }

    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;

        return $this;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function setTotal($total, $tax = 0.0)
    {
        $this->preTaxTotal = (double)$total;
        $this->tax = (double)$tax;
        $this->postTaxTotal = (double)$total + (double)$tax;

        return $this;
    }

    public function getPreTaxTotal()
    {
        return (double)$this->preTaxTotal;
    }

    public function getPostTaxTotal()
    {
        return (double)$this->postTaxTotal;
    }

    public function getTax()
    {
        return (double)$this->tax;
    }
}