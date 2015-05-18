<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class CustomerMigrateEvent extends PasswordedEvent
{
    private $uuid;

    public function __construct(Merchant $merchant, $uuid)
    {
        parent::__construct($merchant);
        $this->uuid = $uuid;
    }

    public function getUuid()
    {
        return $this->uuid;
    }
}