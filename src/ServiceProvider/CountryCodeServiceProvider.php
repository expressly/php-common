<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\CountryCodeProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CountryCodeServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['country_code.provider'] = $container->protect(function () use ($container) {
            return new CountryCodeProvider($container['config']['country_code']);
        });
    }
}