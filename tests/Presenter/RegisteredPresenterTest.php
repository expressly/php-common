<?php

use Expressly\Presenter\RegisteredPresenter;

class RegisteredPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $presenter = new RegisteredPresenter();

        $this->assertEquals(
            array(
                'registered' => true,
                'lightbox' => 'javascript',
                'version' => 'V2'
            ),
            $presenter->toArray()
        );

        $this->assertJson(json_encode($presenter->toArray()));
    }
}