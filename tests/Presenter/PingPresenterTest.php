<?php

use Expressly\Presenter\PingPresenter;

class PingPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $presenter = new PingPresenter();

        $this->assertEquals(
            array('expressly' => 'Stuff is happening!'),
            $presenter->toArray()
        );

        $this->assertJson(json_encode($presenter->toArray()));
    }
}