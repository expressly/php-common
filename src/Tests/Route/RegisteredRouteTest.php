<?php

namespace Expressly\Tests\Route;

use Expressly\Route\Registered;

class RegisteredRouteTest extends AbstractProtectedRouteTest
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
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/registered');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), Registered::getName());
    }
}