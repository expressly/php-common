<?php

namespace Expressly\Event;

use Symfony\Component\EventDispatcher\Event;

class CustomerUpdateEvent extends Event
{
    private $updated;

    public function __construct(\DateTime $updated)
    {
        $this->updated = $updated;
    }

    public function getLastUpdated()
    {
        return $this->updated->getTimestamp();
    }
}