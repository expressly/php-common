<?php

use Buzz\Client\Curl;
use Buzz\Message\Request;
use Buzz\Message\Response;
use Expressly\Entity\ExternalRoute;
use Expressly\Validator\UuidValidator;

class ExternalRouteEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntityWithoutParameters()
    {
        $response = $this->getMockBuilder('Buzz\Message\Response')->getMock();

        $request = $this->getMockBuilder('Buzz\Message\Request')->getMock();

        $client = $this->getMockBuilder('Buzz\Client\Curl')->getMock();

        $entity = new ExternalRoute($response, $request, $client);

        $this->assertInstanceOf('Expressly\Entity\ExternalRoute', $entity->setMethod('GET'));
        $this->assertInstanceOf(
            'Expressly\Entity\ExternalRoute',
            $entity->setHost('https://dev.expresslyapp.com/api/v2')
        );
        $this->assertInstanceOf('Expressly\Entity\ExternalRoute', $entity->setURI('/ping'));
        $this->assertInstanceOf('Expressly\Entity\ExternalRoute', $entity->setRules(array()));
        $this->assertInstanceOf('Expressly\Entity\ExternalRoute', $entity->setParameters(array()));

        $this->assertEquals('GET', $entity->getMethod());
        $this->assertEquals('https://dev.expresslyapp.com/api/v2', $entity->getHost());
        $this->assertEquals('/ping', $entity->getURI());
        $this->assertEquals('https://dev.expresslyapp.com/api/v2/ping', $entity->getURL());
        $this->assertEquals('https://dev.expresslyapp.com/api/v2/ping', (string)$entity);

        $this->assertInstanceOf(
            'Buzz\Message\Response',
            $entity->process(function ($request) {
            })
        );

        $this->assertTrue($entity->isSuccessful());
    }

    public function testMaxRetries()
    {
        $response = $this->getMockBuilder('Buzz\Message\Response')->getMock();
        $response->method('isEmpty')->willReturn(true);

        $request = $this->getMockBuilder('Buzz\Message\Request')->getMock();

        $client = $this->getMockBuilder('Buzz\Client\Curl')->getMock();

        $entity = new ExternalRoute($response, $request, $client);

        $this->assertInstanceOf(
            'Buzz\Message\Response',
            $entity->process(function ($request) {
            })
        );

        $this->assertFalse($entity->isSuccessful());
    }

    public function testBuildingEntityWithPlaceholderAndValidation()
    {
        $entity = new ExternalRoute(new Response(), new Request(), new Curl());
        $entity
            ->setMethod('GET')
            ->setHost('https://dev.expresslyapp.com/api/v2')
            ->setURI('/migration/<uuid>')
            ->setRules(array(
                'uuid' => new UuidValidator('uuid not valid')
            ))
            ->setParameters(array(
                'uuid' => '599edaea-abac-4727-a149-9ffd7b32b9c7'
            ));

        $this->assertEquals(
            'https://dev.expresslyapp.com/api/v2/migration/599edaea-abac-4727-a149-9ffd7b32b9c7',
            $entity->getURL()
        );
    }

    /**
     * @expectedException Expressly\Exception\InvalidURIException
     */
    public function testBuildingEntityWithNoPlaceholderData()
    {
        $entity = new ExternalRoute(new Response(), new Request(), new Curl());
        $entity
            ->setMethod('GET')
            ->setHost('https://dev.expresslyapp.com/api/v2')
            ->setURI('/migration/<uuid>')
            ->setRules(array(
                'uuid' => new UuidValidator('uuid not valid')
            ));

        // raises InvalidURIException
        $entity->getURL();
    }

    /**
     * @expectedException Expressly\Exception\InvalidURIException
     */
    public function testBuildingEntityWithPlaceholderAndInvalidData()
    {
        $entity = new ExternalRoute(new Response(), new Request(), new Curl());
        $entity
            ->setMethod('GET')
            ->setHost('https://dev.expresslyapp.com/api/v2')
            ->setURI('/migration/<uuid>')
            ->setRules(array(
                'uuid' => new UuidValidator('uuid not valid')
            ))
            ->setParameters(array(
                'uuid' => 'not_a_uuid'
            ));

        // raises InvalidURIException
        $entity->getURL();
    }
}