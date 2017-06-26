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
                'version' => 'V2',
                'platformName' => null,
                'platformVersion' => null,
            ),
            $presenter->toArray()
        );

        $this->assertJson(json_encode($presenter->toArray()));
    }

    public function testToArrayWithPlatform()
    {
        $presenter = new RegisteredPresenter('pn', 'pv');

        $this->assertEquals(
            array(
                'registered' => true,
                'lightbox' => 'javascript',
                'version' => 'V2',
                'platformName' => 'pn',
                'platformVersion' => 'pv'
            ),
            $presenter->toArray()
        );

        $this->assertJson(json_encode($presenter->toArray()));
    }
}