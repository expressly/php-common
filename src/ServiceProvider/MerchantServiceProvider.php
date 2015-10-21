<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\MockMerchantProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class MerchantServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['merchant.provider'] = $app->share(function () {
            return new MockMerchantProvider();
        });
    }

    public function boot(Application $app)
    {
    }
}