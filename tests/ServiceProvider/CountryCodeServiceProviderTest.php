<?php

class CountryCodeServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();
    }

    public function testCountryConfigExists()
    {
        $this->assertNotEmpty($this->app['config']['country_code']);
    }

    public function testProviderExistsOnBoot()
    {
        $this->assertInstanceOf('Expressly\Provider\CountryCodeProvider', $this->app['country_code.provider']);
    }
}