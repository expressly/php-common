<?php

use Expressly\Entity\Email;

class EmailEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Email();
        $entity
            ->setEmail('test@test.com')
            ->setAlias('default');

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'email' => 'test@test.com',
                'alias' => 'default'
            ))
        );
    }
}