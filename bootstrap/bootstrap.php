<?php

use Silex\Provider\MonologServiceProvider;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\HttpFoundation\Response;

$package = __DIR__ . '/../../../../vendor/autoload.php';
if (file_exists($package)) {
    require $package;
} else {
    require __DIR__ . '/../vendor/autoload.php';
}

$app = new Silex\Application();

// Monolog
ErrorHandler::register();
$app->register(new MonologServiceProvider(), array(
    'monolog.logfile' => sprintf('%s/../storage/logs/xly-%s.log', __DIR__, date('Y-m-d')),
    'monolog.level' => Monolog\Logger::WARNING,
    'monolog.name' => 'xly'
));

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/services.php';
require_once __DIR__ . '/start.php';

return $app;
