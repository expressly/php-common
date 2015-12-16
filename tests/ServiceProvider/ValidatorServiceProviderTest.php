<?php

class ValidatorServiceProvider extends \PHPUnit_Framework_TestCase
{
    private $app;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();
    }

    public function testConfiguredProvidersExistOnBoot()
    {
        foreach ($this->app['config']['validators'] as $validator) {
            $this->assertInstanceOf($validator['class'], $this->app["{$validator['class']::getType()}.validator"]);
        }
    }
}