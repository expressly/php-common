<?php

use Expressly\Presenter\RegisteredPresenter;

class RegisteredPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $presenter = new RegisteredPresenter();

        $this->assertEquals(
            array('registered' => true),
            $presenter->toArray()
        );

        $this->assertJson(json_encode($presenter->toArray()));
    }
}