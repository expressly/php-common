<?php

use Expressly\Route\UserData;

class UserDataRouteTest extends AbstractRouteTest
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
        $this->mockSecurity();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/user/test@test.com');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), UserData::getName());
    }

    public function test401()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/user/test@test.com');

        if (function_exists('http_response_code')) {
            $this->assertEquals(401, http_response_code());
        }
        $this->assertNull($route);
    }
}