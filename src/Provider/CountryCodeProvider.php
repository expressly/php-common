<?php

namespace Expressly\Provider;

use Doctrine\Common\Collections\ArrayCollection;

class CountryCodeProvider
{
    const COUNTRY_CODE_TYPE_ISO_2 = 'iso2';
    const COUNTRY_CODE_TYPE_ISO_3 = 'iso3';
    const COUNTRY_CODE_TYPE_ISO_M49 = 'm49';
    private $countries;

    public function __construct($countries)
    {
        $this->countries = new ArrayCollection();

        foreach ($countries as $country) {
            $this->countries->add($country);
        }
    }

    public function getIso2($code)
    {
        $country = $this->getByCode($code);
        return is_array($country) ? (string)$country[self::COUNTRY_CODE_TYPE_ISO_2] : false;
    }

    private function getByCode($code)
    {
        $type = $this->getCodeType($code);

        if (!$type) {
            return false;
        }

        return $this->countries->filter(function ($country) use ($type, $code) {
            if ($country[$type] == $code) {
                return true;
            }

            return false;
        })->first();
    }

    private function getCodeType($code)
    {
        if (strlen($code) == 2) {
            return self::COUNTRY_CODE_TYPE_ISO_2;
        }

        if (strlen($code) == 3) {
            return (int)((string)$code) > 0 ? self::COUNTRY_CODE_TYPE_ISO_M49 : self::COUNTRY_CODE_TYPE_ISO_3;
        }

        return false;
    }

    public function getIso3($code)
    {
        $country = $this->getByCode($code);
        return is_array($country) ? (string)$country[self::COUNTRY_CODE_TYPE_ISO_3] : false;
    }

    public function getM49($code)
    {
        $country = $this->getByCode($code);
        return is_array($country) ? (string)$country[self::COUNTRY_CODE_TYPE_ISO_M49] : false;
    }
}