<?php

use Expressly\Entity\Merchant;
use Expressly\Event\MerchantEvent;

class MerchantEventTest extends \PHPUnit_Framework_TestCase
{
    public function testRequiredFields()
    {
        $merchant = new Merchant();

        $event = new MerchantEvent($merchant);

        $this->assertInstanceOf('Expressly\Entity\Merchant', $event->getMerchant());
    }
}