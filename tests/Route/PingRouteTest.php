<?php

use Expressly\Route\Ping;

class PingRouteTest extends AbstractRouteTest
{
    public function testName()
    {
        $this->assertEquals(Ping::getName(), 'ping');
    }

    public function testRegex()
    {
        $this->assertRegExp(Ping::getRegex(), '/expressly/api/ping/');
        $this->assertRegExp(Ping::getRegex(), '/expressly/api/ping');
        $this->assertRegExp(Ping::getRegex(), 'expressly/api/ping/');
        $this->assertRegExp(Ping::getRegex(), 'expressly/api/ping');
    }

    public function testMethod()
    {
        $this->assertEquals(Ping::getMethod(), 'GET');
    }

    public function testAuthorization()
    {
        $this->assertFalse(Ping::isAuthenticated());
    }

    public function testResolver()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/ping');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), Ping::getName());
    }
}