<?php

namespace Expressly\Tests\Route;

use Expressly\Route\BatchInvoice;

class BatchInvoiceRouteTest extends AbstractProtectedRouteTest
{
    public function testName()
    {
        $this->assertEquals(BatchInvoice::getName(), 'batch_invoice');
    }

    public function testRegex()
    {
        $this->assertRegExp(BatchInvoice::getRegex(), '/expressly/api/batch/invoice/');
        $this->assertRegExp(BatchInvoice::getRegex(), '/expressly/api/batch/invoice');
        $this->assertRegExp(BatchInvoice::getRegex(), 'expressly/api/batch/invoice/');
        $this->assertRegExp(BatchInvoice::getRegex(), 'expressly/api/batch/invoice');
    }

    public function testMethod()
    {
        $this->assertEquals(BatchInvoice::getMethod(), 'POST');
    }

    public function testAuthorization()
    {
        $this->assertTrue(BatchInvoice::isAuthenticated());
    }

    public function testResolver()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $route = $this->routeResolver->process('/expressly/api/batch/invoice');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), BatchInvoice::getName());
    }
}