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

        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->setFirstName('Sam'));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->setLastName('Pratt'));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->setGender(Customer::GENDER_MALE));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->setCompany('Expressly'));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->setBirthday(new \DateTime('1990-01-01')));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->setTaxNumber('tax'));
        $this->assertInstanceOf(
            'Expressly\Entity\Customer',
            $entity->setDateUpdated(new \DateTime('2015-12-12 05:00:00'))
        );
        $this->assertInstanceOf(
            'Expressly\Entity\Customer',
            $entity->setDateLastOrder(new \DateTime('2015-12-12 05:00:00'))
        );
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->setNumberOrdered(1));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->addSocial($social));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->addEmail($email));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->addPhone($phone));
        $this->assertInstanceOf(
            'Expressly\Entity\Customer',
            $entity->addAddress($address, true, Address::ADDRESS_BOTH)
        );

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
        $emailA = new Email();
        $emailA
            ->setAlias('default')
            ->setEmail('test@test.com');

        $emailB = new Email();
        $emailB
            ->setAlias('backup')
            ->setEmail('test@backup.com');

        $entity = new Customer();
        $entity
            ->addEmail($emailA)
            ->addEmail($emailA)
            ->addEmail($emailB);

        $this->assertEquals(0, $entity->getEmailIndex($emailA));
        $this->assertEquals(1, $entity->getEmailIndex($emailB));
    }

    public function testEmailDoesNotExist()
    {
        $email = new Email();
        $email
            ->setAlias('similar')
            ->setEmail('test@test.com');

        $entity = new Customer();

        $this->assertFalse($entity->getEmailIndex($email));
    }

    public function testNoDuplicatePhones()
    {
        $phoneA = new Phone();
        $phoneA
            ->setCountryCode(44)
            ->setNumber('07951234567')
            ->setType(Phone::PHONE_TYPE_MOBILE);

        $phoneB = new Phone();
        $phoneB
            ->setCountryCode(44)
            ->setNumber('07957654321')
            ->setType(Phone::PHONE_TYPE_MOBILE);

        $entity = new Customer();
        $entity
            ->addPhone($phoneA)
            ->addPhone($phoneA)
            ->addPhone($phoneB);

        $this->assertEquals(0, $entity->getPhoneIndex($phoneA));
        $this->assertEquals(1, $entity->getPhoneIndex($phoneB));
    }

    public function testPhoneDoesNotExist()
    {
        $phone = new Phone();
        $phone
            ->setCountryCode(1)
            ->setNumber('6127701999')
            ->setType(Phone::PHONE_TYPE_HOME);

        $entity = new Customer();

        $this->assertFalse($entity->getPhoneIndex($phone));
    }

    public function testNoDuplicateAddresses()
    {
        $addressA = new Address();
        $addressA
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

        $addressB = new Address();
        $addressB
            ->setFirstName('Bob')
            ->setLastName('TheBuilder')
            ->setCompanyName('Builders Inc');

        $entity = new Customer();

        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->addAddress($addressA, true));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->addAddress($addressA, true));
        $this->assertInstanceOf('Expressly\Entity\Customer', $entity->addAddress($addressB, false));

        $entityArray = $entity->toArray();
        $this->assertCount(2, $entityArray['addresses']);
    }
}