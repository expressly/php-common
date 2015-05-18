<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class MerchantEvent extends ResponseEvent
{
    private $merchant;

    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    public function getMerchant()
    {
        return $this->merchant;
    }
}