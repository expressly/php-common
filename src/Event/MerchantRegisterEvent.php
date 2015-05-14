<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class MerchantRegisterEvent extends ResponseEvent
{
    private $merchant;
    private $location;

    public function __construct(Merchant $merchant, $location)
    {
        $this->merchant = $merchant;
        $this->location = $location;
    }

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function getLocation() {
        return $this->location;
    }
}