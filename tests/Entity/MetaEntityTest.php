<?php

use Expressly\Entity\Generic;
use Expressly\Entity\Meta;

class MetaEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $generic = new Generic();
        $generic
            ->setField('field')
            ->setValue('value');

        $entity = new Meta();

        $this->assertInstanceOf('Expressly\Entity\Meta', $entity->addIssuerData($generic));
        $this->assertInstanceOf('Expressly\Entity\Meta', $entity->setLocale('en'));

        $this->assertEquals('en', $entity->getLocale());
        $this->assertEquals('phpunit', $entity->getSender());
        $this->assertInstanceOf('Doctrine\Common\Collections\ArrayCollection', $entity->getIssuerData());
        $this->assertEquals(1, $entity->getIssuerData()->count());

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'locale' => 'en',
                'sender' => 'phpunit',
                'issuerData' => array(
                    array(
                        'field' => 'field',
                        'value' => 'value'
                    )
                )
            ))
        );
    }

    public function testRemoveEntity()
    {
        $generic = new Generic();
        $generic
            ->setField('field')
            ->setValue('value');

        $entity = new Meta();

        $this->assertInstanceOf('Expressly\Entity\Meta', $entity->addIssuerData($generic));
        $this->assertEquals(1, $entity->getIssuerData()->count());
        $this->assertInstanceOf('Expressly\Entity\Meta', $entity->removeIssuerData($generic));
        $this->assertEquals(0, $entity->getIssuerData()->count());
    }
}