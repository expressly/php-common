<?php

// Register ServiceProviders
$app->register(new Expressly\ServiceProvider\ValidatorServiceProvider());
$app->register(new Expressly\ServiceProvider\ExternalRouteServiceProvider());
$app->register(new Expressly\ServiceProvider\MerchantServiceProvider());
$app->register(new Expressly\ServiceProvider\CountryCodeServiceProvider());
$app->register(new Expressly\ServiceProvider\RouteResolverServiceProvider());
$app->register(new Expressly\ServiceProvider\DispatcherServiceProvider());
