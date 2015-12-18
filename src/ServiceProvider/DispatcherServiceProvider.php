<?php

namespace Expressly\ServiceProvider;

use Expressly\Subscriber\BannerSubscriber;
use Expressly\Subscriber\CustomerMigrationSubscriber;
use Expressly\Subscriber\MerchantSubscriber;
use Expressly\Subscriber\UtilitySubscriber;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * @codeCoverageIgnore
 */
class DispatcherServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['dispatcher'] = function () {
            return new EventDispatcher();
        };

        $container['dispatcher']->addSubscriber(new CustomerMigrationSubscriber($container));
        $container['dispatcher']->addSubscriber(new MerchantSubscriber($container));
        $container['dispatcher']->addSubscriber(new BannerSubscriber($container));
        $container['dispatcher']->addSubscriber(new UtilitySubscriber($container));
    }
}