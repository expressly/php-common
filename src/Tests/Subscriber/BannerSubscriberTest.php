<?php

namespace Expressly\Test\Subscriber;

use Expressly\Entity\Merchant;
use Expressly\ServiceProvider\ExternalRouteServiceProvider;
use Expressly\Subscriber\BannerSubscriber;

class BannerSubscriberTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        require __DIR__ . '/../bootstrap.php';

        $this->app = $app->getApp();
        $this->app->register(new ExternalRouteServiceProvider());
    }

    public function tearDown()
    {
        $this->app = null;
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

        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array($merchant, 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('isSuccessful')
            ->willReturn(true);
        $bannerEvent
            ->method('getContent')
            ->willReturn(array(
                'bannerImageUrl' => '',
                'migrationLink' => ''
            ));

        $subscriber->onRequest($bannerEvent);

        $this->assertTrue($bannerEvent->isSuccessful());
        $this->assertArrayHasKey('bannerImageUrl', $bannerEvent->getContent());
        $this->assertArrayHasKey('migrationLink', $bannerEvent->getContent());
    }
}