<?php

use Expressly\Presenter\PingPresenter;

class PingPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $presenter = new PingPresenter();

        $this->assertEquals(
            array('installed' => 'v2'),
            $presenter->toArray()
        );

        $this->assertJson(json_encode($presenter->toArray()));
    }
}