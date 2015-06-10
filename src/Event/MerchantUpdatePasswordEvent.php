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

    public function getToken()
    {
        return base64_encode(sprintf('%s:%s', $this->merchant->getUuid(), $this->getOldPassword()));
    }

    public function getOldPassword()
    {
        return $this->oldPassword;
    }
}