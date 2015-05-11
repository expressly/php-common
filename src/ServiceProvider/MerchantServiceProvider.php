<?php

namespace Expressly\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class MerchantServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['merchant.provider'] = $app->share(function ($app) {
            $name = $app['config']['provider']['merchant'];

            return new $name($app);
        });
    }

    public function boot(Application $app)
    {
    }
}