<?php

use Expressly\Entity\Merchant;
use Expressly\Event\CustomerMigrateEvent;

class CustomerMigrateEventTest extends \PHPUnit_Framework_TestCase
{
    public function testRequiredFields()
    {
        $merchant = new Merchant();
        $merchant->setApiKey('dXNlcm5hbWU6cGFzc3dvcmQ=');

        $event = new CustomerMigrateEvent($merchant, '7e73aeb8-4e38-4dc4-b6a9-9fff5b2a39f7');

        $this->assertEquals('7e73aeb8-4e38-4dc4-b6a9-9fff5b2a39f7', $event->getUuid());
        $this->assertEquals(CustomerMigrateEvent::MIGRATED_CUSTOMER, $event->getStatus());
        $this->assertEquals('Authorization: Basic dXNlcm5hbWU6cGFzc3dvcmQ=', $event->getBasicHeader());
    }
}