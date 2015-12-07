<?php

namespace Expressly\ServiceProvider;

use Expressly\Resolver\RouteResolver;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class RouteResolverServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['route.resolver'] = $container->protect(function ($container) {
            return new RouteResolver($container, $container['config']['routes']);
        });
    }
}