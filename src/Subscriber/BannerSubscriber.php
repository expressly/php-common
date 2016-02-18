<?php

namespace Expressly\Subscriber;

use Expressly\Event\BannerEvent;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BannerSubscriber implements EventSubscriberInterface
{
    private $container;
    private $routeProvider;

    const BANNER_REQUEST = 'banner.request';

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->routeProvider = $container['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            self::BANNER_REQUEST => array('onRequest', 0)
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function onRequest(BannerEvent $event)
    {
        $route = $this->routeProvider->banner_request;
        $route->setParameters(array(
            'uuid' => $event->getUuid(),
            'email' => $event->getEmail()
        ));

        $response = $route->process(function ($request) use ($event) {
            $request->addHeader($event->getBasicHeader());
        });

        $event->setResponse($response);
    }
}