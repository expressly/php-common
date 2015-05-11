<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;
use Silex\Application;
use Symfony\Component\EventDispatcher\Event;

class MerchantEvent extends Event
{
    private $merchant;
    private $oldPassword;

    public function __construct(Merchant $merchant, $oldPassword = null)
    {
        $this->merchant = $merchant;
        $this->oldPassword = $oldPassword;
    }

    public function getMerchant()
    {
        return $this->merchant;
    }

    public function getOldPassword()
    {
        return $this->oldPassword;
    }
}