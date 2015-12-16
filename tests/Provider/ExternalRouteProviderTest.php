<?php

use Expressly\Provider\ExternalRouteProvider;

class ExternalRouteProviderTest extends \PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        global $client;
        $app = $client->getApp();

        $this->provider = new ExternalRouteProvider(
            $app,
            $app['config']['external']['hosts'],
            $app['config']['external']['routes']
        );

    }

    public function testRouteExists()
    {
        $this->assertInstanceOf('Expressly\Entity\ExternalRoute', $this->provider->ping);
    }

    public function testRouteDoesNotExist()
    {
        $this->assertNull($this->provider->somewhere_not_defined);
    }
}