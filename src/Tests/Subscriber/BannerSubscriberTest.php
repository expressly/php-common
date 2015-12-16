<?php

namespace Expressly\Tests\Subscriber;

use Expressly\Entity\Merchant;
use Expressly\Subscriber\BannerSubscriber;

class BannerSubscriberTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();
    }

    public function testSubscribedEvents()
    {
        $this->assertTrue(
            array_key_exists(
                BannerSubscriber::BANNER_REQUEST,
                BannerSubscriber::getSubscribedEvents()
            )
        );
    }

    public function testRequest()
    {
        $merchant = new Merchant();
        $merchant->setApiKey('NTA2MDIwOTUtYzM5MC00YThmLWJjODgtNzI4ZDcyNWIxNDEwOnBhc3N3b3Jk');

        $subscriber = $this->getMockBuilder('Expressly\Subscriber\BannerSubscriber')
            ->setConstructorArgs(array($this->app))
            ->getMock();

        $event = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array($merchant, 'test@email.com'))
            ->getMock();

        $event->method('isSuccessful')->willReturn(true);
        $event->method('getContent')->willReturn(array(
            'bannerImageUrl' => '',
            'migrationLink' => ''
        ));

//        $subscriber->onRequest($event);

        $this->assertTrue($event->isSuccessful());
        $this->assertArrayHasKey('bannerImageUrl', $event->getContent());
        $this->assertArrayHasKey('migrationLink', $event->getContent());
    }
}