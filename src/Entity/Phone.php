<?php

namespace Expressly\Entity;

class Phone extends ArraySerializeable
{
    const PHONE_TYPE_MOBILE = 'M';
    const PHONE_TYPE_HOME = 'L';

    protected $type;
    protected $number;
    protected $countryCode;

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        if ($type == self::PHONE_TYPE_HOME) {
            $this->type = self::PHONE_TYPE_HOME;
        }
        if ($type == self::PHONE_TYPE_MOBILE) {
            $this->type = self::PHONE_TYPE_MOBILE;
        }

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function setCountryCode($code)
    {
        $this->countryCode = $code;

        return $this;
    }
}