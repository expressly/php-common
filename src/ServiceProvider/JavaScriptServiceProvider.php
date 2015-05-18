<?php

namespace Expressly\ServiceProvider;

use Expressly\Provider\JavaScriptProvider;
use Silex\Application;
use Silex\ServiceProviderInterface;

class JavaScriptServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['js.provider'] = $app->share(function ($app) {
            return new JavaScriptProvider();
        });
    }

    public function boot(Application $app)
    {
    }
}