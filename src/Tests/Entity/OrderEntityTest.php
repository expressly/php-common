<?php

namespace Expressly\Tests\Entity;

use Expressly\Entity\Order;

class OrderEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Order();
        $entity
            ->setId('ORDER-531')
            ->setDate(new \DateTime('2015-08-08 13:00:00 +00:00'))
            ->setItemCount(1)
            ->setCoupon('25OFF')
            ->setCurrency('GBP')
            ->setTotal(35.00, 2.00);

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'id' => 'ORDER-531',
                'date' => '2015-08-08T13:00:00+0000',
                'itemCount' => 1,
                'coupon' => '25OFF',
                'currency' => 'GBP',
                'preTaxTotal' => 35.00,
                'postTaxTotal' => 37.00,
                'tax' => 2.00
            ))
        );
    }
}