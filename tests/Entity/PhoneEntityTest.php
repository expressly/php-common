<?php

use Expressly\Entity\Phone;

class PhoneEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Phone();
        $entity
            ->setType(Phone::PHONE_TYPE_MOBILE)
            ->setCountryCode(44)
            ->setNumber('07951234567');

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'type' => 'M',
                'countryCode' => 44,
                'number' => '07951234567'
            ))
        );
    }
}