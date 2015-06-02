<?php

namespace Expressly\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['db'] = $app->share(function ($app) {
            $config = $app['config']['database'];
            $dsn = sprintf('%s:dbname=%s;host=%s', $config['driver'], $config['dbname'], $config['host']);

            return new \PDO($dsn, $config['user'], $config['password']);
        });
    }

    public function boot(Application $app)
    {
    }
}