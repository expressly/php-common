<?php

namespace Expressly\Test\Subscriber;

use Expressly\Client;
use Expressly\Entity\Merchant;
use Expressly\Provider\ExternalRouteProvider;
use Expressly\Subscriber\BannerSubscriber;

class BannerSubscriberTest extends \PHPUnit_Framework_TestCase
{
    protected $app;

    public function setUp()
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';

        $client = new Client('phpunit', array('debug' => true));
        $app = $client->getApp();
        $app['external_route.provider'] = new ExternalRouteProvider(
            $app,
            array(
                'default' => 'http://localhost:8080/api/v1'
            ),
            array(
                'banner_request' => array(
                    'host' => 'default',
                    'method' => 'GET',
                    'uri' => '/banner/<uuid>?email=<email>'
                )
            )
        );

        $this->app = $app;
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
        $merchant
            ->setUuid('50602095-c390-4a8f-bc88-728d725b1410')
            ->setPassword('password');

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