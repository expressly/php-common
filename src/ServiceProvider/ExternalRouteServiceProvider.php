<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\ExternalRouteProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * @codeCoverageIgnore
 */
class ExternalRouteServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['external_route.provider'] = function () use ($container) {
            return new ExternalRouteProvider(
                $container,
                $container['config']['external']['hosts'],
                $container['config']['external']['routes']
            );
        };
    }
}