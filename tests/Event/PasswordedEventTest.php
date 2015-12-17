<?php

use Expressly\Entity\Merchant;
use Expressly\Event\PasswordedEvent;

class PasswordedEventTest extends \PHPUnit_Framework_TestCase
{
    public function testRequiredFields()
    {
        $merchant = new Merchant();
        $merchant->setApiKey('dXNlcm5hbWU6cGFzc3dvcmQ=');

        $event = new PasswordedEvent($merchant);

        $this->assertInstanceOf('Expressly\Entity\Merchant', $event->getMerchant());
        $this->assertEquals('username', $event->getUuid());
        $this->assertEquals('password', $event->getPassword());
        $this->assertEquals('dXNlcm5hbWU6cGFzc3dvcmQ=', $event->getApiKey());
        $this->assertEquals('Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=', $event->getBasicHeader());
    }
}