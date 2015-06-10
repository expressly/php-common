<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\ExternalRouteProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class ExternalRouteServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['external_route.provider'] = $app->share(function ($app) {
            return new ExternalRouteProvider(
                $app,
                $app['config']['external']['hosts'],
                $app['config']['external']['routes']
            );
        });
    }

    public function boot(Application $app)
    {
    }
}