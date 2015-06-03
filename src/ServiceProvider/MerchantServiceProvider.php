<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\MerchantProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class MerchantServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['merchant.provider'] = $app->share(function ($app) {
            return new MerchantProvider($app);
        });
    }

    public function boot(Application $app)
    {
    }
}