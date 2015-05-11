<?php

namespace Expressly\Event;

use Expressly\Entity\Customer;
use Symfony\Component\EventDispatcher\Event;

class CustomerMigrateEvent extends Event
{
    private $customer;
    private $email;
    private $reference;

    public function __construct(Customer $customer, $email, $reference)
    {
        $this->customer = $customer;
        $this->email = $email;
        $this->reference = $reference;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getReference()
    {
        return $this->reference;
    }
}