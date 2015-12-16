<?php

use Expressly\Entity\Customer;
use Expressly\Entity\Merchant;
use Expressly\Presenter\CustomerMigratePresenter;

class CustomerMigratePresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruction()
    {
        $merchant = new Merchant();
        $merchant->setPath('/');

        $customer = new Customer();
        $customer->setFirstName('Test');
        $customer->setLastName('User');

        $presenter = new CustomerMigratePresenter($merchant, $customer, 'test@test.com', '58', 'en');

        return $presenter;
    }

    /**
     * @depends testConstruction
     */
    public function testToArray($presenter)
    {
        $this->assertSame(
            array(
                'meta' => array(
                    'locale' => 'en',
                    'issuerData' => array(
                        array(
                            'field' => 'expressly_path',
                            'value' => '/'
                        )
                    )
                ),
                'data' => array(
                    'email' => 'test@test.com',
                    'userReference' => '58',
                    'customerData' => array(
                        'firstName' => 'Test',
                        'lastName' => 'User',
                        'onlinePresence' => array(),
                        'emails' => array(),
                        'phones' => array(),
                        'addresses' => array()
                    )
                )
            ),
            $presenter->toArray()
        );

        $this->assertJson(json_encode($presenter->toArray()));
    }
}