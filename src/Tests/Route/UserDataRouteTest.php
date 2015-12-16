<?php

namespace Expressly\Tests\Route;

use Expressly\Route\UserData;

class UserDataRouteTest extends AbstractProtectedRouteTest
{
    public function testName()
    {
        $this->assertEquals(UserData::getName(), 'user_data');
    }

    public function testRegex()
    {
        $this->assertRegExp(UserData::getRegex(), '/expressly/api/user/test@test.com/');
        $this->assertRegExp(UserData::getRegex(), '/expressly/api/user/test@test.com');
        $this->assertRegExp(UserData::getRegex(), 'expressly/api/user/test@test.com/');
        $this->assertRegExp(UserData::getRegex(), 'expressly/api/user/test@test.com');
    }

    public function testMethod()
    {
        $this->assertEquals(UserData::getMethod(), 'GET');
    }

    public function testAuthorization()
    {
        $this->assertTrue(UserData::isAuthenticated());
    }

    public function testResolver()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/user/test@test.com');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), UserData::getName());
    }
}