<?php

namespace Expressly\Tests\Route;

abstract class AbstractUnprotectedRouteTest extends \PHPUnit_Framework_TestCase
{
    protected $routeResolver;

    public function setUp()
    {
        global $client;
        $app = $client->getApp();

        $this->routeResolver = $app['route.resolver'];
    }

    public function tearDown()
    {
        $this->routeResolver = null;
    }
}