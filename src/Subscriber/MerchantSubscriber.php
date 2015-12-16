<?php

namespace Expressly\Subscriber;

use Expressly\Event\PasswordedEvent;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MerchantSubscriber implements EventSubscriberInterface
{
    private $container;
    private $routeProvider;

    const MERCHANT_REGISTER = 'merchant.register';
    const MERCHANT_DELETE = 'merchant.delete';

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->routeProvider = $container['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            self::MERCHANT_REGISTER => array('onRegister', 0),
            self::MERCHANT_DELETE => array('onDelete', 0)
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function onRegister(PasswordedEvent $event)
    {
        $route = $this->routeProvider->merchant_register;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader($event->getBasicHeader());
            $request->setContent(array(
                'apiKey' => $event->getApiKey(),
                'apiBaseUrl' => $merchant->getEndpoint()
            ));
        });

        $event->setResponse($response);
    }

    /**
     * @codeCoverageIgnore
     */
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