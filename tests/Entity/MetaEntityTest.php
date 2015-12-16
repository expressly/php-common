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
        $entity
            ->addIssuerData($generic)
            ->setLocale('en');

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
}