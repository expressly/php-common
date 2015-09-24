<?php

namespace Expressly\Subscriber;

use Expressly\Event\ResponseEvent;
use Silex\Application;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UtilitySubscriber implements EventSubscriberInterface
{
    private $app;
    private $routeProvider;

    const UTILITY_PING = 'utility.ping';

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->routeProvider = $app['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            self::UTILITY_PING => array('onPing', 0)
        );
    }

    public function onPing(ResponseEvent $event)
    {
        $route = $this->routeProvider->ping;

        $response = $route->process();

        $event->setResponse($response);
    }
}