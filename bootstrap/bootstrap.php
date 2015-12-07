<?php

$package = __DIR__ . '/../../../../vendor/autoload.php';
if (file_exists($package)) {
    require $package;
} else {
    require __DIR__ . '/../vendor/autoload.php';
}

use Expressly\Logger\DummyLogger;
use Expressly\ServiceProvider\MonologServiceProvider;

$app = new Pimple\Container();

require_once __DIR__ . '/config.php';

try {
    $app->register(new MonologServiceProvider($app), array('monolog.name' => $merchantType));
} catch (\Exception $e) {
    $app['logger'] = function () {
        return new DummyLogger();
    };
}

require_once __DIR__ . '/services.php';

return $app;
