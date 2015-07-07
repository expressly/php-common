<?php

namespace Expressly\Entity;

class Address extends ArraySerializeable
{
    const ADDRESS_BILLING = 'billing';
    const ADDRESS_SHIPPING = 'shipping';
    const ADDRESS_BOTH = 'both';

    protected $firstName;
    protected $lastName;
    protected $address1;
    protected $address2;
    protected $city;
    protected $companyName;
    protected $zip;
    protected $phone;
    protected $alias;
    protected $stateProvince;
    protected $country;

    public static function compare(Address $a, Address $b)
    {
        if ($a->toArray() == $b->toArray()) {
            return true;
        }

        return false;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getAddress1()
    {
        return $this->address1;
    }

    public function setAddress1($addressLine)
    {
        $this->address1 = $addressLine;

        return $this;
    }

    public function getAddress2()
    {
        return $this->address2;
    }

    public function setAddress2($addressLine)
    {
        $this->address2 = $addressLine;

        return $this;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    public function setPhonePosition($phone)
    {
        $this->phone = (int)$phone;

        return $this;
    }

    public function getPhonePosition()
    {
        return $this->phone;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    public function getStateProvince()
    {
        return $this->stateProvince;
    }

    public function setStateProvince($stateProvince)
    {
        $this->stateProvince = $stateProvince;

        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }
}