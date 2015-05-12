<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;
use Expressly\Entity\Order;

class OrderUpdateEvent extends PasswordedEvent
{
    protected $email;
    protected $order;

    public function __construct(Merchant $merchant, $email, Order $order)
    {
        parent::__construct($merchant);
        $this->email = $email;
        $this->order = $order;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getorder()
    {
        return $this->order;
    }
}