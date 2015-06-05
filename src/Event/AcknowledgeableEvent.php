<?php

namespace Expressly\Event;

use Expressly\Entity\Merchant;

class AcknowledgeableEvent extends PasswordedEvent
{
    private $acknowledge;

    public function __construct(Merchant $merchant, $acknowledge)
    {
        parent::__construct($merchant);
        $this->acknowledge = $acknowledge;
    }

    public function getAcknowledge()
    {
        return (bool)$this->acknowledge;
    }
}