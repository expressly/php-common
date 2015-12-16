<?php

use Expressly\Presenter\BatchCustomerPresenter;

class BatchCustomerPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        return new BatchCustomerPresenter(array('exists'), array('deleted'), array('pending'));
    }

    /**
     * @depends testConstruction
     */
    public function testToArray($presenter)
    {
        $this->assertEquals(
            array(
                'existing' => array('exists'),
                'deleted' => array('deleted'),
                'pending' => array('pending')
            ),
            $presenter->toArray()
        );

        $this->assertJson(json_encode($presenter->toArray()));
    }
}