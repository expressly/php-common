<?php

use Expressly\Entity\Phone;

class PhoneEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateMobile()
    {
        $entity = new Phone();

        $this->assertInstanceOf('Expressly\Entity\Phone', $entity->setType(Phone::PHONE_TYPE_MOBILE));
        $this->assertInstanceOf('Expressly\Entity\Phone', $entity->setCountryCode(44));
        $this->assertInstanceOf('Expressly\Entity\Phone', $entity->setNumber('07951234567'));

        $this->assertEquals(Phone::PHONE_TYPE_MOBILE, $entity->getType());
        $this->assertEquals(44, $entity->getCountryCode());
        $this->assertEquals('07951234567', $entity->getNumber());

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

    public function testCreateHome()
    {
        $entity = new Phone();
        $entity
            ->setType(Phone::PHONE_TYPE_HOME)
            ->setCountryCode(44)
            ->setNumber('02123456789');

        $this->assertEquals(Phone::PHONE_TYPE_HOME, $entity->getType());
        $this->assertEquals(44, $entity->getCountryCode());
        $this->assertEquals('02123456789', $entity->getNumber());

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'type' => 'L',
                'countryCode' => 44,
                'number' => '02123456789'
            ))
        );
    }
}