<?php

namespace Expressly\Subscriber;

use Expressly\Event\MerchantEvent;
use Expressly\Event\PasswordedEvent;
use Silex\Application;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MerchantSubscriber implements EventSubscriberInterface
{
    private $app;
    private $routeProvider;

    const MERCHANT_REGISTER = 'merchant.register';
    const MERCHANT_DELETE = 'merchant.delete';

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->routeProvider = $app['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            self::MERCHANT_REGISTER => array('onRegister', 0),
            self::MERCHANT_DELETE => array('onDelete', 0)
        );
    }

    public function onRegister(MerchantEvent $event)
    {
        $route = $this->routeProvider->merchant_register;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->setContent(array(
                'apiKey' => $merchant->getApiKey(),
                'apiBaseUrl' => $merchant->getEndpoint()
            ));
        });

        $event->setResponse($response);
    }

    public function onDelete(PasswordedEvent $event)
    {
        $route = $this->routeProvider->merchant_delete;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));

        $response = $route->process(function ($request) use ($event) {
            $request->addHeader($event->getBasicHeader());
        });

        $event->setResponse($response);
    }
}