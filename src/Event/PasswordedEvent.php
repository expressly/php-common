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
        return "Authorization: Basic {$this->getApiKey()}";
    }

    public function getApiKey()
    {
        return $this->getMerchant()->getApiKey();
    }

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function getPassword()
    {
        return $this->getMerchant()->getPassword();
    }
}