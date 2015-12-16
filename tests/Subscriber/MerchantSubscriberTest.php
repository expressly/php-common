<?php

use Expressly\Subscriber\MerchantSubscriber;

class MerchantSubscriberTest extends \PHPUnit_Framework_TestCase
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

        $subscriber = $this->getMockBuilder('Expressly\Subscriber\MerchantSubscriber')
            ->setConstructorArgs(array($this->app))
            ->getMock();

        $this->assertInstanceOf('Expressly\Subscriber\MerchantSubscriber', $subscriber);
    }

    public function testSubscribedEvents()
    {
        $this->assertArrayHasKey(MerchantSubscriber::MERCHANT_REGISTER, MerchantSubscriber::getSubscribedEvents());
        $this->assertArrayHasKey(MerchantSubscriber::MERCHANT_DELETE, MerchantSubscriber::getSubscribedEvents());
    }
}