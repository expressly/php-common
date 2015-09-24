<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class PasswordedEvent extends MerchantEvent
{
    public function __construct(Merchant $merchant)
    {
        parent::__construct($merchant);
    }

    public function getUuid()
    {
        return $this->merchant->getUuid();
    }

    public function getBasicHeader()
    {
        return "Authorization: Basic {$this->getToken()}";
    }

    public function getToken()
    {
        return base64_encode(sprintf('%s:%s', $this->merchant->getUuid(), $this->merchant->getPassword()));
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