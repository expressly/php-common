<?php

use Expressly\Entity\Generic;

class GenericEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Generic();

        $this->assertInstanceOf('Expressly\Entity\Generic', $entity->setField('field'));
        $this->assertInstanceOf('Expressly\Entity\Generic', $entity->setValue('value'));

        $this->assertEquals('field', $entity->getField());
        $this->assertEquals('value', $entity->getValue());

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'field' => 'field',
                'value' => 'value'
            ))
        );
    }
}