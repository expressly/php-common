<?php

namespace Expressly\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class ValidatorServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        foreach ($app['config']['validators'] as $definition) {
            $validator = new $definition['class']($definition['message']);

            $app["{$validator->getType()}.validator"] = $app->share(function () use ($validator) {
                return $validator;
            });
        }
    }

    public function boot(Application $app)
    {
    }
}