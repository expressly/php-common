<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\CountryCodeProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * @codeCoverageIgnore
 */
class CountryCodeServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['country_code.provider'] = function () use ($container) {
            return new CountryCodeProvider($container['config']['country_code']);
        };
    }
}