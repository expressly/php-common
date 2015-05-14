<?php

namespace Expressly\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Customer extends ArraySerializeable
{
    protected $firstName;
    protected $lastName;
    protected $gender;
    protected $billingAddress;
    protected $shippingAddress;
    protected $company;
    protected $dob;
    protected $taxNumber;
    protected $onlinePresence;
    protected $dateUpdated;
    protected $dateLastOrder;
    protected $numberOrdered;
    protected $emails;
    protected $phones;
    protected $addresses;

    public function __construct()
    {
        $this->onlinePresence = new ArrayCollection();
        $this->emails = new ArrayCollection();
        $this->phones = new ArrayCollection();
        $this->addresses = new ArrayCollection();
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    public function setBirthday($birthday)
    {
        $this->dob = $birthday;

        return $this;
    }

    public function setTaxNumber($taxNumber)
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function setDateUpdated(\DateTime $date)
    {
        $this->dateUpdated = $date->getTimestamp();

        return $this;
    }

    public function setDateLastOrder(\DateTime $date)
    {
        $this->dateLastOrder = $date->getTimestamp();

        return $this;
    }

    public function setNumberOrdered($number)
    {
        $this->numberOrdered = $number;

        return $this;
    }

    public function addSocial(Social $social)
    {
        $this->onlinePresence->add($social);

        return $this;
    }

    public function addEmail(Email $email)
    {
        $this->emails->add($email);

        return $this;
    }

    public function addPhone(Phone $phone)
    {
        $this->phones->add($phone);

        return $this;
    }

    public function addAddress(Address $address, $primary = false, $type = null)
    {
        $this->addresses->add($address);

        if (!$primary) {
            return $this;
        }

        $index = $this->addresses->indexOf($address);
        if ($type == Address::ADDRESS_BILLING) {
            $this->billingAddress = $index;
        }
        if ($type == Address::ADDRESS_SHIPPING) {
            $this->shippingAddress = $index;
        }

        return $this;
    }
}