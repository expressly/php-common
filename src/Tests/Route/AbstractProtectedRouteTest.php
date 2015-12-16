<?php

namespace Expressly\Tests\Route;

abstract class AbstractProtectedRouteTest extends \PHPUnit_Framework_TestCase
{
    protected $routeResolver;

    public function setUp()
    {
        global $client;
        $app = $client->getApp();

        $merchant = $app['merchant.provider']->getMerchant();
        $merchant->setApiKey('dXNlcm5hbWU6cGFzc3dvcmQ=');
        $app['merchant.provider']->setMerchant($merchant);
        $_SERVER['PHP_AUTH_USER'] = 'username';
        $_SERVER['PHP_AUTH_PW'] = 'password';

        $this->routeResolver = $app['route.resolver'];
    }

    public function tearDown()
    {
        $this->routeResolver = null;
    }
}