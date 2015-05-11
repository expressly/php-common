<?php

namespace Expressly\Event;

use Expressly\Entity\Order;
use Symfony\Component\EventDispatcher\Event;

class OrderUpdateEvent extends Event
{
    protected $email;
    protected $order;

    public function __construct($email, Order $order)
    {
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