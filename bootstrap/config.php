<?php

$app->register(new DerAlex\Silex\YamlConfigServiceProvider(__DIR__ . '/../src/Resources/config/config.yml'));
$app['debug'] = $app['config']['debug'];