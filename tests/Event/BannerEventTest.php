<?php

use Expressly\Entity\Merchant;
use Expressly\Event\BannerEvent;

class BannerEventTest extends \PHPUnit_Framework_TestCase
{
    public function testRequiredFields()
    {
        $merchant = new Merchant();
        $merchant->setApiKey('dXNlcm5hbWU6cGFzc3dvcmQ=');

        $event = new BannerEvent($merchant, 'test@test.com');

        $this->assertEquals('test@test.com', $event->getEmail());
        $this->assertEquals('Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=', $event->getBasicHeader());
        $this->assertEquals('username', $event->getUuid());
    }
}