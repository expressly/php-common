<?php

namespace Expressly\Tests\ServiceProvider;

class YamlConfigServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();
    }

    public function testConfigExistsOnBoot()
    {
        $this->assertNotEmpty($this->app['config']);
    }
}