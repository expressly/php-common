<?php

// Register ServiceProviders
$app->register(new Expressly\ServiceProvider\ExternalRouteServiceProvider());
$app->register(new Expressly\ServiceProvider\MerchantServiceProvider());
$app->register(new Expressly\ServiceProvider\JavaScriptServiceProvider());

// Register events
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\CustomerSubscriber($app));
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\CustomerMigrationSubscriber($app));
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\MerchantSubscriber($app));
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\UtilitySubscriber($app));