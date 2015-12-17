<?php

use Expressly\Entity\Address;

class AddressEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Address();

        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setFirstName('Sam'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setLastName('Pratt'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setAddress1('Address1'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setAddress2('Address2'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setCity('London'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setCompanyName('Expressly'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setZip('W2 6LG'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setPhonePosition(0));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setAlias('shipping'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setStateProvince('England'));
        $this->assertInstanceOf('Expressly\Entity\Address', $entity->setCountry('GBR'));

        $this->assertEquals('Sam', $entity->getFirstName());
        $this->assertEquals('Pratt', $entity->getLastName());
        $this->assertEquals('Address1', $entity->getAddress1());
        $this->assertEquals('Address2', $entity->getAddress2());
        $this->assertEquals('London', $entity->getCity());
        $this->assertEquals('Expressly', $entity->getCompanyName());
        $this->assertEquals('W2 6LG', $entity->getZip());
        $this->assertEquals(0, $entity->getPhonePosition());
        $this->assertEquals('shipping', $entity->getAlias());
        $this->assertEquals('England', $entity->getStateProvince());
        $this->assertEquals('GBR', $entity->getCountry());

        $this->assertJson(json_encode($entity->toArray()));
        $this->assertJsonStringEqualsJsonString(
            json_encode($entity->toArray()),
            json_encode(array(
                'firstName' => 'Sam',
                'lastName' => 'Pratt',
                'address1' => 'Address1',
                'address2' => 'Address2',
                'city' => 'London',
                'companyName' => 'Expressly',
                'zip' => 'W2 6LG',
                'phone' => 0,
                'alias' => 'shipping',
                'stateProvince' => 'England',
                'country' => 'GBR'
            ))
        );
    }

    public function testCompareClonedAddresses()
    {
        $addressA = new Address();
        $addressA
            ->setFirstName('Sam')
            ->setLastName('Pratt')
            ->setCompanyName('Expressly');

        $addressB = clone $addressA;

        $this->assertTrue(Address::compare($addressA, $addressB));
    }

    public function testCompareDifferentAddresses()
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
            ->setAlias('shipping')
            ->setStateProvince('England')
            ->setCountry('GBR');

        $addressB = new Address();
        $addressB
            ->setFirstName('Bob')
            ->setLastName('TheBuilder')
            ->setCompanyName('Builder Inc');

        $this->assertFalse(Address::compare($addressA, $addressB));
    }
}