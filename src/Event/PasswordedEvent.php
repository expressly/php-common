<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class PasswordedEvent extends ResponseEvent
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