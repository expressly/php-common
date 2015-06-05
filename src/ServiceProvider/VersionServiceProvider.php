<?php

namespace Expressly\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class VersionServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['version'] = $app['config']['version'];
    }

    public function boot(Application $app)
    {
    }
}