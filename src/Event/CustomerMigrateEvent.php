<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class CustomerMigrateEvent extends PasswordedEvent
{
    const MIGRATED_CUSTOMER = 'migrated';
    const EXISTING_CUSTOMER = 'existing_customer';
    private $uuid;
    private $status;

    public function __construct(Merchant $merchant, $uuid, $status = self::MIGRATED_CUSTOMER)
    {
        parent::__construct($merchant);
        $this->uuid = $uuid;
        $this->status = $status;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function getStatus()
    {
        return $this->status;
    }
}