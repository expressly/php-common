<?php

namespace Expressly\ServiceProvider;

use Monolog\Handler\RedisHandler;
use Monolog\Logger;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Predis\Client;
use Symfony\Bridge\Monolog\Handler\DebugHandler;

class MonologServiceProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['logger'] = function () use ($container) {
            return $container['monolog'];
        };

        if ($bridge = class_exists('Symfony\Bridge\Monolog\Logger')) {
            $container['monolog.handler.debug'] = function () use ($container) {
                return new DebugHandler($container['monolog.level']);
            };
        }

        $container['monolog.logger.class'] = $bridge ? 'Symfony\Bridge\Monolog\Logger' : 'Monolog\Logger';

        $container['monolog'] = function ($container) {
            $log = new $container['monolog.logger.class']($container['monolog.name']);

            $log->pushHandler($container['monolog.handler']);

            if ($container['debug'] && isset($container['monolog.handler.debug'])) {
                $log->pushHandler($container['monolog.handler.debug']);
            }

            return $log;
        };

        $container['monolog.handler'] = function () use ($container) {
            return new RedisHandler(
                new Client('tcp://internal.expresslyapp.com:6379'),
                $_SERVER['HTTP_HOST'],
                Logger::WARNING,
                true
            );
            //return new StreamHandler($container['monolog.logfile'], $container['monolog.level']);
        };

        $container['monolog.level'] = function () {
            return Logger::WARNING;
        };

        $container['monolog.name'] = 'expressly';
    }
}