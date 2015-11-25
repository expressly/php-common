<?php

namespace Expressly\ServiceProvider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ValidatorServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        foreach ($container['config']['validators'] as $definition) {
            $validator = new $definition['class']($definition['message']);

            $container["{$validator->getType()}.validator"] = function () use ($validator) {
                return $validator;
            };
        }
    }
}