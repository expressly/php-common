<?php

namespace Expressly\Tests\Entity;

use Expressly\Entity\Merchant;

class MerchantEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Merchant();
        $entity
            ->setApiKey('dXNlcm5hbWU6cGFzc3dvcmQ=')
            ->setHost('https://a-shop.com')
            ->setPath('/');

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'apiKey' => 'dXNlcm5hbWU6cGFzc3dvcmQ=',
                'host' => 'https://a-shop.com',
                'path' => '/'
            ))
        );

        $this->assertEquals('username', $entity->getUuid());
        $this->assertEquals('password', $entity->getPassword());
    }
}