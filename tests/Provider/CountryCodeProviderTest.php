<?php

use Expressly\Provider\CountryCodeProvider;

class CountryCodeProviderTest extends \PHPUnit_Framework_TestCase
{
    private $provider;

    public function setUp()
    {
        $this->provider = new CountryCodeProvider(array(
            array(
                'iso2' => 'GB',
                'iso3' => 'GBR',
                'm49' => '826'
            )
        ));
    }

    public function testIso2Exists()
    {
        $this->assertNotFalse($this->provider->getIso2('GB'));
    }

    public function testIso2DoesNotExist()
    {
        $this->assertFalse($this->provider->getIso2('AA'));
    }

    public function testIso3Exists()
    {
        $this->assertNotFalse($this->provider->getIso3('GBR'));
    }

    public function testIso3DoesNotExist()
    {
        $this->assertFalse($this->provider->getIso3('AAA'));
    }

    public function testM49Exists()
    {
        $this->assertNotFalse($this->provider->getM49('826'));
    }

    public function testM49DoesNotExist()
    {
        $this->assertFalse($this->provider->getM49('111'));
    }

    public function testInvalidType()
    {
        $this->assertFalse($this->provider->getIso2('invalid'));
    }
}