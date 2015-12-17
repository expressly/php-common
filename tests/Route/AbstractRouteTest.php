<?php

abstract class AbstractRouteTest extends \PHPUnit_Framework_TestCase
{
    protected $app;
    protected $routeResolver;

    public function setUp()
    {
        global $client;
        $this->app = $client->getApp();

        $this->routeResolver = $this->app['route.resolver'];
    }

    public function mockSecurity()
    {
        $merchant = $this->app['merchant.provider']->getMerchant();
        $merchant->setApiKey('dXNlcm5hbWU6cGFzc3dvcmQ=');
        $this->app['merchant.provider']->setMerchant($merchant);

        $_SERVER['PHP_AUTH_USER'] = 'username';
        $_SERVER['PHP_AUTH_PW'] = 'password';
    }

    public function tearDown()
    {
        $this->routeResolver = null;
        unset($_SERVER['PHP_AUTH_USER']);
        unset($_SERVER['PHP_AUTH_PW']);
    }
}