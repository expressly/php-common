<?php

use Expressly\Route\BatchInvoice;

class BatchInvoiceRouteTest extends AbstractRouteTest
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
        $this->mockSecurity();

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $route = $this->routeResolver->process('/expressly/api/batch/invoice');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), BatchInvoice::getName());
    }

    public function test401()
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $route = $this->routeResolver->process('/expressly/api/batch/invoice');

        if (function_exists('http_response_code')) {
            $this->assertEquals(401, http_response_code());
        }
        $this->assertNull($route);
    }
}