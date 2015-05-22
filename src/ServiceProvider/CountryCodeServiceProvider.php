<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\CountryCodeProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class CountryCodeServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['country_code.provider'] = new CountryCodeProvider($app['config']['country_code']);
    }

    public function boot(Application $app)
    {
    }
}