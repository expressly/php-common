<?php

namespace Expressly\Event;

use Expressly\Entity\Customer;
use Expressly\Entity\Merchant;
use Symfony\Component\EventDispatcher\Event;

class CustomerMigrateEvent extends PasswordedEvent
{
    private $customer;
    private $email;
    private $reference;

    public function __construct(Merchant $merchant, Customer $customer, $email, $reference)
    {
        parent::__construct($merchant);
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