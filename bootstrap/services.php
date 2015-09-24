<?php

// Register ServiceProviders
$app->register(new Expressly\ServiceProvider\VersionServiceProvider());
$app->register(new Expressly\ServiceProvider\ValidatorServiceProvider());
$app->register(new Expressly\ServiceProvider\ExternalRouteServiceProvider());
$app->register(new Expressly\ServiceProvider\MerchantServiceProvider());
$app->register(new Expressly\ServiceProvider\JavaScriptServiceProvider());
$app->register(new Expressly\ServiceProvider\CountryCodeServiceProvider());

// Register events
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\CustomerMigrationSubscriber($app));
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\MerchantSubscriber($app));
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\BannerSubscriber($app));
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\UtilitySubscriber($app));