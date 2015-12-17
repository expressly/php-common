<?php

use Expressly\Entity\Order;

class OrderEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Order();

        $this->assertInstanceOf('Expressly\Entity\Order', $entity->setId('ORDER-531'));
        $this->assertInstanceOf(
            'Expressly\Entity\Order',
            $entity->setDate(new \DateTime('2015-08-08 13:00:00 +00:00'))
        );
        $this->assertInstanceOf('Expressly\Entity\Order', $entity->setItemCount(1));
        $this->assertInstanceOf('Expressly\Entity\Order', $entity->setCoupon('25OFF'));
        $this->assertInstanceOf('Expressly\Entity\Order', $entity->setCurrency('GBP'));
        $this->assertInstanceOf('Expressly\Entity\Order', $entity->setTotal(35.00, 2.00));

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