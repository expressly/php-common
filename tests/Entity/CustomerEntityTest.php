<?php

use Expressly\Entity\Address;
use Expressly\Entity\Customer;
use Expressly\Entity\Email;
use Expressly\Entity\Phone;
use Expressly\Entity\Social;

class CustomerEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $social = new Social();
        $social
            ->setField(Social::SOCIAL_FACEBOOK)
            ->setValue('https://www.facebook.com/expresslyUK');

        $email = new Email();
        $email
            ->setAlias('default')
            ->setEmail('test@test.com');

        $phone = new Phone();
        $phone
            ->setCountryCode(44)
            ->setNumber('07951234567')
            ->setType(Phone::PHONE_TYPE_MOBILE);

        $address = new Address();
        $address
            ->setFirstName('Sam')
            ->setLastName('Pratt')
            ->setAddress1('Address1')
            ->setAddress2('Address2')
            ->setCity('London')
            ->setCompanyName('Expressly')
            ->setZip('W2 6LG')
            ->setPhonePosition(0)
            ->setAlias('billing')
            ->setStateProvince('England')
            ->setCountry('GBR');

        $entity = new Customer();
        $entity
            ->setFirstName('Sam')
            ->setLastName('Pratt')
            ->setGender(Customer::GENDER_MALE)
            ->setCompany('Expressly')
            ->setBirthday(new \DateTime('1990-01-01'))
            ->setTaxNumber('tax')
            ->setDateUpdated(new \DateTime('2015-12-12 05:00:00'))
            ->setDateLastOrder(new \DateTime('2015-12-12 05:00:00'))
            ->setNumberOrdered(1)
            ->addSocial($social)
            ->addEmail($email)
            ->addPhone($phone)
            ->addAddress($address, true, Address::ADDRESS_BOTH);

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'firstName' => 'Sam',
                'lastName' => 'Pratt',
                'gender' => 'M',
                'billingAddress' => 0,
                'shippingAddress' => 0,
                'company' => 'Expressly',
                'dob' => '1990-01-01',
                'taxNumber' => 'tax',
                'dateUpdated' => '2015-12-12T05:00:00+0000',
                'dateLastOrder' => '2015-12-12T05:00:00+0000',
                'numberOrdered' => 1,
                'onlinePresence' => array(
                    array(
                        'field' => 'facebook',
                        'value' => 'https://www.facebook.com/expresslyUK'
                    )
                ),
                'emails' => array(
                    array(
                        'alias' => 'default',
                        'email' => 'test@test.com'
                    )
                ),
                'phones' => array(
                    array(
                        'countryCode' => 44,
                        'number' => '07951234567',
                        'type' => 'M'
                    )
                ),
                'addresses' => array(
                    array(
                        'firstName' => 'Sam',
                        'lastName' => 'Pratt',
                        'address1' => 'Address1',
                        'address2' => 'Address2',
                        'city' => 'London',
                        'companyName' => 'Expressly',
                        'zip' => 'W2 6LG',
                        'phone' => 0,
                        'alias' => 'billing',
                        'stateProvince' => 'England',
                        'country' => 'GBR'
                    )
                )
            ))
        );
    }

    public function testNoDuplicateEmails()
    {

    }

    public function testNoDuplicatePhones()
    {

    }

    public function testNoDuplicateAddresses()
    {

    }

    public function testCorrectPhoneForAddress()
    {

    }
}