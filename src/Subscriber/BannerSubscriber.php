<?php

namespace Expressly\Subscriber;

use Expressly\Event\BannerEvent;
use Silex\Application;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BannerSubscriber implements EventSubscriberInterface
{
    private $app;
    private $routeProvider;

    const BANNER_REQUEST = 'banner.request';

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->routeProvider = $app['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            self::BANNER_REQUEST => array('onRequest', 0)
        );
    }

    public function onRequest(BannerEvent $event)
    {
        $route = $this->routeProvider->banner_request;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));
        $version = $this->app['version'];

        $response = $route->process(function ($request) use ($event, $version) {
            $merchant = $event->getMerchant();

            $request->addHeader($event->getBasicHeader());
            $request->setContent(array(
                'uuid' => $merchant->getUuid(),
                'email' => $event->getEmail()
            ));
        });

        $event->setResponse($response);
    }
}