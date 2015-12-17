<?php

use Expressly\ServiceProvider\RouteResolverServiceProvider;

class RouteResolverTest extends \PHPUnit_Framework_TestCase
{
    protected $app;
    protected $routeResolver;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();

        $this->routeResolver = new RouteResolverServiceProvider($this->app);
    }

    public function testProviderExistsOnBoot()
    {
        $this->assertInstanceOf('Expressly\ServiceProvider\RouteResolverServiceProvider', $this->routeResolver);
        $this->assertInstanceOf('Expressly\Resolver\RouteResolver', $this->app['route.resolver']);
    }
}