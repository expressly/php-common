<?php

namespace Expressly\Tests\ServiceProvider;

class ExternalRouteServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();
    }

    public function testHostConfigExists()
    {
        $this->assertNotEmpty($this->app['config']['external']['hosts']);
    }

    public function testRouteConfigExists()
    {
        $this->assertNotEmpty($this->app['config']['external']['routes']);
    }

    public function testProviderExistsOnBoot()
    {
        $this->assertInstanceOf('Expressly\Provider\ExternalRouteProvider', $this->app['external_route.provider']);
    }
}