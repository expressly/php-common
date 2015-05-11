<?php

// Register ServiceProviders
$app->register(new Expressly\ServiceProvider\ExternalRouteServiceProvider());
$app->register(new Expressly\ServiceProvider\MerchantServiceProvider());

// Register events
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\CustomerSubscriber($app));
$app['dispatcher']->addSubscriber(new Expressly\Subscriber\MerchantSubscriber($app));
$app['dispatcher']->addSubscrbier(new Expressly\Subscriber\UtilitySubscriber($app));