<?php

namespace Expressly\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ApiVersionServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['api_version'] = $app['config']['api_version'];
    }

    public function boot(Application $app)
    {
    }
}