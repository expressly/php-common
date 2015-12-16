<?php

namespace Expressly\Tests\Entity;

use Expressly\Entity\Address;

class AddressEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testBuildingEntity()
    {
        $entity = new Address();
        $entity
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
}