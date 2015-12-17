<?php

use Expressly\Entity\Email;

class EmailEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Email();

        $this->assertInstanceOf('Expressly\Entity\Email', $entity->setEmail('test@test.com'));
        $this->assertInstanceOf('Expressly\Entity\Email', $entity->setAlias('default'));

        $this->assertEquals('test@test.com', $entity->getEmail());
        $this->assertEquals('default', $entity->getAlias());

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