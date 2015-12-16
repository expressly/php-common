<?php

use Expressly\Subscriber\UtilitySubscriber;

class UtilitySubscriberTest extends \PHPUnit_Framework_TestCase
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

        $subscriber = $this->getMockBuilder('Expressly\Subscriber\UtilitySubscriber')
            ->setConstructorArgs(array($this->app))
            ->getMock();

        $this->assertInstanceOf('Expressly\Subscriber\UtilitySubscriber', $subscriber);
    }

    public function testSubscribedEvents()
    {
        $this->assertArrayHasKey(UtilitySubscriber::UTILITY_PING, UtilitySubscriber::getSubscribedEvents());
    }
}