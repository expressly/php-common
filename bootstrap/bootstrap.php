<?php

use Expressly\Logger\DummyLogger\DummyLogger;
use Monolog\Handler\RedisHandler;
use Monolog\Logger;
use Predis\Client;
use Silex\Provider\MonologServiceProvider;

$package = __DIR__ . '/../../../../vendor/autoload.php';
if (file_exists($package)) {
    require $package;
} else {
    require __DIR__ . '/../vendor/autoload.php';
}

$app = new Silex\Application();

require_once __DIR__ . '/config.php';

try {
    $app->register(new MonologServiceProvider(), array(
        'monolog.level' => Logger::WARNING,
        'monolog.name' => $merchantType,
        'monolog.handler' => $app->share(function () {
            // Configuration not being accessible anymore from $app directly after being instantiated.
            return new RedisHandler(
                new Client('tcp://prod.expresslyapp.com:6379'),
                $_SERVER['HTTP_HOST'],
                Logger::WARNING,
                true
            );
        })
    ));
} catch (\Exception $e) {
    $app['logger'] = $app->share(function () {
        return new DummyLogger();
    });
}

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/services.php';
require_once __DIR__ . '/start.php';

return $app;
