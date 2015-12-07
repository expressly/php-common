<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\MockMerchantProvider;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class MerchantServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['merchant.provider'] = function () {
            return new MockMerchantProvider();
        };
    }
}