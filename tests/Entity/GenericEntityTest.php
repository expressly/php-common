<?php

use Expressly\Entity\Generic;

class GenericEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Generic();
        $entity
            ->setField('field')
            ->setValue('value');

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