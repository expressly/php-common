<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class MerchantLocationEvent extends PasswordedEvent
{
    private $location;

    public function __construct(Merchant $merchant, $location)
    {
        parent::__construct($merchant);
        $this->host = $location;
    }

    public function getLocation()
    {
        return $this->location;
    }
}