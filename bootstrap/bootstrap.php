<?php

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

$app->register(new MonologServiceProvider(), array(
    'monolog.level' => Monolog\Logger::WARNING,
    'monolog.name' => $merchantType,
    'monolog.handler' => $app->share(function ($app) {
        // Configuration not being accessible anymore from $app directly after being instantiated.
        return new RedisHandler(new Client('tcp://dev.expresslyapp.com:6379'), $_SERVER['HTTP_HOST'], Logger::WARNING, true);
    })
));

require_once __DIR__ . '/database.php';
require_once __DIR__ . '/services.php';
require_once __DIR__ . '/start.php';

return $app;
