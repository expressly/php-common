<?php

namespace Expressly\Event;

use Expressly\Entity\Customer;
use Symfony\Component\EventDispatcher\Event;

class CustomerEvent extends Event
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer()
    {
        return $this->customer;
    }
}