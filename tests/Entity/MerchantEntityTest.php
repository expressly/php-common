<?php

use Expressly\Entity\Merchant;

class MerchantEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Merchant();

        $this->assertInstanceOf('Expressly\Entity\Merchant', $entity->setApiKey('dXNlcm5hbWU6cGFzc3dvcmQ='));
        $this->assertInstanceOf('Expressly\Entity\Merchant', $entity->setHost('https://a-shop.com'));
        $this->assertInstanceOf('Expressly\Entity\Merchant', $entity->setPath('/'));

        $this->assertEquals('https://a-shop.com', $entity->getHost());
        $this->assertEquals('/', $entity->getPath());
        $this->assertEquals('dXNlcm5hbWU6cGFzc3dvcmQ=', $entity->getApiKey());
        $this->assertEquals('username', $entity->getUuid());
        $this->assertEquals('password', $entity->getPassword());

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'apiKey' => 'dXNlcm5hbWU6cGFzc3dvcmQ=',
                'host' => 'https://a-shop.com',
                'path' => '/'
            ))
        );
    }

    public function testComparisonDifferentApiKey()
    {
        $merchantA = new Merchant();
        $merchantA
            ->setApiKey('abc')
            ->setHost('https://a-shop.com')
            ->setPath('/');

        $merchantB = new Merchant();
        $merchantB
            ->setApiKey('def')
            ->setHost('https://a-shop.com')
            ->setPath('/');

        $this->assertFalse(Merchant::compare($merchantA, $merchantB));
    }

    public function testComparisonDifferentEndpoint()
    {
        $merchantA = new Merchant();
        $merchantA
            ->setApiKey('abc')
            ->setHost('https://a-shop.com')
            ->setPath('/');

        $merchantB = new Merchant();
        $merchantB
            ->setApiKey('abc')
            ->setHost('https://a-shop.com')
            ->setPath('/shop2');

        $this->assertFalse(Merchant::compare($merchantA, $merchantB));
    }
}