<?php

namespace Expressly\Tests\ServiceProvider;

class RouteResolverTest extends \PHPUnit_Framework_TestCase
{
    protected $routeResolver;

    public function setUp()
    {
        global $client;
        $app = $client->getApp();

        $this->routeResolver = $app['route.resolver'];
    }

    public function testProviderExistsOnBoot()
    {
        $this->assertInstanceOf('Expressly\Resolver\RouteResolver', $this->routeResolver);
    }
}