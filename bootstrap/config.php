<?php

$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../src/Resources/config/config.yml'));

// Overwrite default values with those passed in from Expressly\Client
$app['config'] = array_replace_recursive($app['config'], $config);