<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class MerchantUpdatePasswordEvent extends PasswordedEvent
{
    private $oldPassword;

    public function __construct(Merchant $merchant, $oldPassword)
    {
        parent::__construct($merchant);

        $this->oldPassword = $oldPassword;
    }

    public function getOldPassword()
    {
        return $this->oldPassword;
    }
}