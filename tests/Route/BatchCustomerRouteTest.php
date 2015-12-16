<?php

use Expressly\Route\BatchCustomer;

class BatchCustomerRouteTest extends AbstractRouteTest
{
    public function testName()
    {
        $this->assertEquals(BatchCustomer::getName(), 'batch_customer');
    }

    public function testRegex()
    {
        $this->assertRegExp(BatchCustomer::getRegex(), '/expressly/api/batch/customer/');
        $this->assertRegExp(BatchCustomer::getRegex(), '/expressly/api/batch/customer');
        $this->assertRegExp(BatchCustomer::getRegex(), 'expressly/api/batch/customer/');
        $this->assertRegExp(BatchCustomer::getRegex(), 'expressly/api/batch/customer');
    }

    public function testMethod()
    {
        $this->assertEquals(BatchCustomer::getMethod(), 'POST');
    }

    public function testAuthorization()
    {
        $this->assertTrue(BatchCustomer::isAuthenticated());
    }

    public function testResolver()
    {
        $this->mockSecurity();

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $route = $this->routeResolver->process('/expressly/api/batch/customer');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), BatchCustomer::getName());
    }

    public function test401()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $route = $this->routeResolver->process('/expressly/api/batch/customer');

        if (function_exists('http_response_code')) {
            $this->assertEquals(401, http_response_code());
        }
        $this->assertNull($route);
    }
}