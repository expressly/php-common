<?php

use Expressly\Presenter\BatchInvoicePresenter;

class BatchInvoicePresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $invoice = $this->getMockBuilder('Expressly\Entity\Invoice')->getMock();
        $invoice->method('toArray')->willReturn(array(
            'email' => 'test@test.com',
            'orderCount' => 2,
            'preTaxTotal' => 100.00,
            'postTaxTotal' => 110.00,
            'tax' => 10.00,
            'orders' => array(
                array(
                    'id' => 'ORDER-531',
                    'date' => '2015-08-08T13:00:00+0000',
                    'itemCount' => 1,
                    'coupon' => '25OFF',
                    'currency' => 'GBP',
                    'preTaxTotal' => 35.00,
                    'postTaxTotal' => 37.00,
                    'tax' => 2.00
                ),
                array(
                    'id' => 'ORDER-875',
                    'date' => '2015-09-09T15:00:00+0000',
                    'itemCount' => 1,
                    'currency' => 'GBP',
                    'preTaxTotal' => 65.00,
                    'postTaxTotal' => 73.00,
                    'tax' => 8.00
                )
            )
        ));

        $invoices = array(
            $invoice,
            array('not an invoice')
        );

        $presenter = new BatchInvoicePresenter($invoices);

        return $presenter->toArray();
    }

    /**
     * @depends testConstruction
     */
    public function testCount(array $array)
    {
        $this->assertCount(1, $array['invoices']);
    }
}