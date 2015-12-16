<?php

namespace Expressly\Tests\Route;

use Expressly\Route\BatchCustomer;

class BatchCustomerRouteTest extends AbstractProtectedRouteTest
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
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $route = $this->routeResolver->process('/expressly/api/batch/customer');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), BatchCustomer::getName());
    }
}