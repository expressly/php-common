<?php

namespace Expressly\Event;

use Symfony\Component\EventDispatcher\Event;

class MerchantHostEvent extends Event
{
    private $host;

    public function __construct($host) {
        $this->host = $host;
    }

    public function getHost() {
        return $this->host;
    }
}