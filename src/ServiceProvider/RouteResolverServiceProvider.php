<?php

namespace Expressly\ServiceProvider;

use Expressly\Resolver\RouteResolver;
use Silex\Application;
use Silex\ServiceProviderInterface;

class RouteResolverServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['route.resolver'] = $app->share(function ($app) {
            return new RouteResolver($app, $app['config']['routes']);
        });
    }

    public function boot(Application $app)
    {
    }
}