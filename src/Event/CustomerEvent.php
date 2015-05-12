<?php

namespace Expressly\Event;

use Expressly\Entity\Customer;
use Expressly\Entity\Merchant;

class CustomerEvent extends PasswordedEvent
{
    protected $customer;

    public function __construct(Merchant $merchant, Customer $customer)
    {
        parent::__construct($merchant);
        $this->customer = $customer;
    }

    public function getCustomer()
    {
        return $this->customer;
    }
}