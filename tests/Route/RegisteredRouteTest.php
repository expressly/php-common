<?php

use Expressly\Route\Registered;

class RegisteredRouteTest extends AbstractRouteTest
{
    public function testName()
    {
        $this->assertEquals(Registered::getName(), 'registered');
    }

    public function testRegex()
    {
        $this->assertRegExp(Registered::getRegex(), '/expressly/api/registered/');
        $this->assertRegExp(Registered::getRegex(), '/expressly/api/registered');
        $this->assertRegExp(Registered::getRegex(), 'expressly/api/registered/');
        $this->assertRegExp(Registered::getRegex(), 'expressly/api/registered');
    }

    public function testMethod()
    {
        $this->assertEquals(Registered::getMethod(), 'GET');
    }

    public function testAuthorization()
    {
        $this->assertTrue(Registered::isAuthenticated());
    }

    public function testResolver()
    {
        $this->mockSecurity();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/registered');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), Registered::getName());
    }

    public function test401()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/registered');

        if (function_exists('http_response_code')) {
            $this->assertEquals(401, http_response_code());
        }
        $this->assertNull($route);
    }
}