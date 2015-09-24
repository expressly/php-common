<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class BannerEvent extends PasswordedEvent
{
    private $email;

    public function __construct(Merchant $merchant, $email)
    {
        parent::__construct($merchant);
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}