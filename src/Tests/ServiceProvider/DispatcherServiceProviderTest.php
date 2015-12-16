<?php

namespace Expressly\Tests\ServiceProvider;

use Expressly\Subscriber\BannerSubscriber;
use Expressly\Subscriber\CustomerMigrationSubscriber;
use Expressly\Subscriber\MerchantSubscriber;
use Expressly\Subscriber\UtilitySubscriber;

class DispatcherServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();
    }

    public function testProviderExistsOnBoot()
    {
        $this->assertInstanceOf('Symfony\Component\EventDispatcher\EventDispatcher', $this->app['dispatcher']);
    }

    public function testCustomerMigrationSubscriberIsRegistered()
    {
        foreach (CustomerMigrationSubscriber::getSubscribedEvents() as $name => $event) {
            $this->assertTrue($this->app['dispatcher']->hasListeners($name));
        }
    }

    public function testMerchantSubscriberIsRegistered()
    {
        foreach (MerchantSubscriber::getSubscribedEvents() as $name => $event) {
            $this->assertTrue($this->app['dispatcher']->hasListeners($name));
        }
    }

    public function testBannerSubscriberIsRegistered()
    {
        foreach (BannerSubscriber::getSubscribedEvents() as $name => $event) {
            $this->assertTrue($this->app['dispatcher']->hasListeners($name));
        }
    }

    public function testUtilitySubscriberIsRegistered()
    {
        foreach (UtilitySubscriber::getSubscribedEvents() as $name => $event) {
            $this->assertTrue($this->app['dispatcher']->hasListeners($name));
        }
    }
}