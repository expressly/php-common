<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;

// Router
$app['routes'] = $app->extend('routes', function (RouteCollection $routes, $app) {
    $loader = new YamlFileLoader(new FileLocator(__DIR__ . '/../src/Resources/config'));
    $collection = $loader->load('routes.yml');
    $routes->addCollection($collection);
    $routes->addPrefix('expressly/api');

    return $routes;
});

// Before request
$app->before(function (Request $request) use ($app) {
    $merchant = $app['merchant.provider']->getMerchant();

    if ($request->headers->has('Authorization')) {
        if (!$request->headers->contains('Authorization', $merchant->getPassword())) {
            $exception = new AccessDeniedHttpException('Access Denied.');

            return new JsonResponse($exception->getMessage(), $exception->getStatusCode(), $exception->getHeaders());
        }
    }
});

// After request
$app->after(function (Request $request, Response $response) {
    $response->headers->add(array('X-Powered-By' => 'Copious amounts of Alcohol; mostly Beer.'));
});