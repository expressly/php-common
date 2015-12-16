<?php

use Expressly\Subscriber\BannerSubscriber;

class BannerSubscriberTest extends \PHPUnit_Framework_TestCase
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

        $subscriber = $this->getMockBuilder('Expressly\Subscriber\BannerSubscriber')
            ->setConstructorArgs(array($this->app))
            ->getMock();

        $this->assertInstanceOf('Expressly\Subscriber\BannerSubscriber', $subscriber);
    }

    public function testStaticEventDefinitions()
    {
        $this->assertEquals('banner.request', BannerSubscriber::BANNER_REQUEST);
    }

    public function testSubscribedEvents()
    {
        $this->assertArrayHasKey(BannerSubscriber::BANNER_REQUEST, BannerSubscriber::getSubscribedEvents());
    }
}