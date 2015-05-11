<?php

namespace Expressly\Subscriber;

use Silex\Application;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UtilitySubscriber implements EventSubscriberInterface
{
    private $app;
    private $routeProvider;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->routeProvider = $app['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            'utility.ping' => array('onPing', 0)
        );
    }

    public function onPing(Event $event)
    {
        return new JsonResponse(array(
            'expressly' => 'Stuff is happening!'
        ));
    }
}