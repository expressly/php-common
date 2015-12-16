<?php

namespace Expressly\Subscriber;

use Expressly\Event\ResponseEvent;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UtilitySubscriber implements EventSubscriberInterface
{
    private $container;
    private $routeProvider;

    const UTILITY_PING = 'utility.ping';

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->routeProvider = $container['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            self::UTILITY_PING => array('onPing', 0)
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function onPing(ResponseEvent $event)
    {
        $route = $this->routeProvider->ping;

        $response = $route->process();

        $event->setResponse($response);
    }
}