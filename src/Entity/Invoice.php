<?php

namespace Expressly\Entity;

class Invoice extends ArraySerializeable
{
    protected $email;
    protected $orderCount = 0;
    protected $preTaxTotal = 0.0;
    protected $postTaxTotal = 0.0;
    protected $tax = 0.0;
    protected $orders = array();

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function addOrder(Order $order)
    {
        $this->orders[] = $order;

        $this->orderCount++;
        $this->preTaxTotal += $order->getPreTaxTotal();
        $this->postTaxTotal += $order->getPostTaxTotal();
        $this->tax += $order->getTax();

        return $this;
    }
}