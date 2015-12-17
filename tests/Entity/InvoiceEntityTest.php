<?php

use Expressly\Entity\Invoice;
use Expressly\Entity\Order;

class InvoiceEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $orderWithCoupon = new Order();
        $orderWithCoupon
            ->setId('ORDER-531')
            ->setDate(new \DateTime('2015-08-08 13:00:00 +00:00'))
            ->setItemCount(1)
            ->setCoupon('25OFF')
            ->setCurrency('GBP')
            ->setTotal(35.00, 2.00);

        $orderWithoutCoupon = new Order();
        $orderWithoutCoupon
            ->setId('ORDER-875')
            ->setDate(new \DateTime('2015-09-09 15:00:00 +00:00'))
            ->setItemCount(1)
            ->setCurrency('GBP')
            ->setTotal(65.00, 8.00);

        $entity = new Invoice();

        $this->assertInstanceOf('Expressly\Entity\Invoice', $entity->setEmail('test@test.com'));
        $this->assertInstanceOf('Expressly\Entity\Invoice', $entity->addOrder($orderWithCoupon));
        $this->assertInstanceOf('Expressly\Entity\Invoice', $entity->addOrder($orderWithoutCoupon));

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
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
            ))
        );
    }
}