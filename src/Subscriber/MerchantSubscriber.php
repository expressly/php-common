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
    const MERCHANT_UPDATE = 'merchant.update';
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
            self::MERCHANT_UPDATE => array('onUpdate', 0),
            self::MERCHANT_DELETE => array('onDelete', 0)
        );
    }

    public function onRegister(MerchantEvent $event)
    {
        $route = $this->routeProvider->merchant_register;
        $version = $this->app['version'];

        $response = $route->process(function ($request) use ($event, $version) {
            $merchant = $event->getMerchant();

            $request->setContent(array(
                'shopName' => $merchant->getName(),
                'shopUrl' => $merchant->getHost(),
                'apiBaseUrl' => $merchant->getEndpoint(),
                'shopImageUrl' => $merchant->getImage(),
                'termsAndConditionsUrl' => $merchant->getTerms(),
                'policyUrl' => $merchant->getPolicy(),
                'pluginVersion' => $version
            ));
        });

        $event->setResponse($response);
    }

    public function onUpdate(PasswordedEvent $event)
    {
        $version = $this->app['version'];
        $route = $this->routeProvider->merchant_update;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));

        $response = $route->process(function ($request) use ($event, $version) {
            $merchant = $event->getMerchant();

            $request->addHeader($event->getBasicHeader());
            $request->setContent(array(
                'shopName' => $merchant->getName(),
                'shopUrl' => $merchant->getHost(),
                'apiBaseUrl' => $merchant->getEndpoint(),
                'shopImageUrl' => $merchant->getImage(),
                'termsAndConditionsUrl' => $merchant->getTerms(),
                'policyUrl' => $merchant->getPolicy(),
                'pluginVersion' => $version
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