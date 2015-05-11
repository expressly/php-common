<?php

namespace Expressly\Event;

use Symfony\Component\EventDispatcher\Event;

class AcknowledgeableEvent extends Event {
    private $acknowledge;

    public function __construct($acknowledge) {
        $this->acknowledge = $acknowledge;
    }

    public function getAcknowledge() {
        return (bool)$this->acknowledge;
    }
}