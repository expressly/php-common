<?php

$app->register(new Expressly\ServiceProvider\YamlConfigServiceProvider(__DIR__ . '/../src/Resources/config/config.yml'));

// overwrite default values with those passed in from Expressly\Client
$app['config'] = array_replace_recursive($app['config'], $config);

$app['debug'] = false;