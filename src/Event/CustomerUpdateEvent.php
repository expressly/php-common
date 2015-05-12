<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class CustomerUpdateEvent extends PasswordedEvent
{
    private $updated;

    public function __construct(Merchant $merchant, \DateTime $updated)
    {
        parent::__construct($merchant);
        $this->updated = $updated;
    }

    public function getLastUpdated()
    {
        return $this->updated->getTimestamp();
    }
}