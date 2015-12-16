<?php

use Expressly\Subscriber\CustomerMigrationSubscriber;

class CustomerMigrationSubscriberTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();
    }

    public function testDependenciesExist()
    {
        $this->assertNotEmpty($this->app['external_route.provider']);

        $subscriber = $this->getMockBuilder('Expressly\Subscriber\CustomerMigrationSubscriber')
            ->setConstructorArgs(array($this->app))
            ->getMock();

        $this->assertInstanceOf('Expressly\Subscriber\CustomerMigrationSubscriber', $subscriber);
    }

    public function testSubscribedEvents()
    {
        $this->assertArrayHasKey(
            CustomerMigrationSubscriber::CUSTOMER_MIGRATE_DATA,
            CustomerMigrationSubscriber::getSubscribedEvents()
        );
        $this->assertArrayHasKey(
            CustomerMigrationSubscriber::CUSTOMER_MIGRATE_POPUP,
            CustomerMigrationSubscriber::getSubscribedEvents()
        );
        $this->assertArrayHasKey(
            CustomerMigrationSubscriber::CUSTOMER_MIGRATE_SUCCESS,
            CustomerMigrationSubscriber::getSubscribedEvents()
        );
    }
}