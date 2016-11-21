<?php

namespace Expressly\Entity;

class EventDetails extends ArraySerializeable
{
    protected $eventName;
    protected $startTime;
    protected $endTime;
    protected $address1;
    protected $address2;
    protected $city;
    protected $zip;
    protected $stateProvince;
    protected $country;

    public static function compare(EventDetails $a, EventDetails $b)
    {
        return $a->toArray() == $b->toArray();
    }

    public function getEventName()
    {
        return $this->eventName;
    }

    public function setEventName($eventName)
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTime $startTime)
    {
        $startTime->setTimezone(new \DateTimeZone('UTC'));
        $this->startTime = $startTime->format(\DateTime::ISO8601);
        return $this;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTime $endTime)
    {
        $endTime->setTimezone(new \DateTimeZone('UTC'));
        $this->endTime = $endTime->format(\DateTime::ISO8601);
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

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;

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