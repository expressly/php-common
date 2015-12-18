<?php

namespace Expressly\ServiceProvider;

use Expressly\Resolver\RouteResolver;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * @codeCoverageIgnore
 */
class RouteResolverServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['route.resolver'] = function () use ($container) {
            return new RouteResolver($container, $container['config']['routes']);
        };
    }
}