<?php

use Expressly\Event\ResponseEvent;

class ResponseEventTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccessfulJsonResponse()
    {
        $event = new ResponseEvent();

        $response = $this->getMockBuilder('Buzz\Message\Response')->getMock();
        $response->method('isSuccessful')->willReturn(true);
        $response->method('getContent')->willReturn('{"json": "string"}');

        $event->setResponse($response);

        $this->assertTrue($event->isSuccessful());
        $this->assertInstanceOf('Buzz\Message\Response', $event->getResponse());
        $this->assertEquals(
            array(
                'json' => 'string'
            ),
            $event->getContent()
        );
    }

    public function testSuccessfulStringResponse()
    {
        $event = new ResponseEvent();

        $response = $this->getMockBuilder('Buzz\Message\Response')->getMock();
        $response->method('isSuccessful')->willReturn(true);
        $response->method('getContent')->willReturn('<h1>HTML</h1>');

        $event->setResponse($response);

        $this->assertTrue($event->isSuccessful());
        $this->assertInstanceOf('Buzz\Message\Response', $event->getResponse());
        $this->assertEquals('<h1>HTML</h1>', $event->getContent());
    }

    public function testSuccessfulArrayResponse()
    {
        $event = new ResponseEvent();

        $response = $this->getMockBuilder('Buzz\Message\Response')->getMock();
        $response->method('isSuccessful')->willReturn(true);
        $response->method('getContent')->willReturn(array('test' => 'array'));

        $event->setResponse($response);

        $this->assertTrue($event->isSuccessful());
        $this->assertInstanceOf('Buzz\Message\Response', $event->getResponse());
        $this->assertEquals(array('test' => 'array'), $event->getContent());
    }

    public function testNoResponse()
    {
        $event = new ResponseEvent();

        $this->assertFalse($event->isSuccessful());
        $this->assertNull($event->getContent());
    }
}