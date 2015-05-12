<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;
use Symfony\Component\EventDispatcher\Event;

class PasswordedEvent extends Event
{
    private $merchant;

    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    public function getPassword()
    {
        return $this->getMerchant()->getPassword();
    }

    public function getMerchant()
    {
        return $this->merchant;
    }
}