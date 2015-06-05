<?php

namespace Expressly\Subscriber;

use Expressly\Event\MerchantEvent;
use Expressly\Event\MerchantUpdatePasswordEvent;
use Silex\Application;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MerchantSubscriber implements EventSubscriberInterface
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
            'merchant.register' => array('onRegister', 0),
            'merchant.update' => array('onUpdate', 0),
            'merchant.delete' => array('onDelete', 0),
            'merchant.password.update' => array('onPasswordUpdate', 0)
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
                'xlyEndpoint' => $merchant->getEndpoint(),
                'shopImageUrl' => $merchant->getImage(),
                'termsAndConditionsUrl' => $merchant->getTerms(),
                'policyUrl' => $merchant->getPolicy(),
                'webshopSystem' => $version
            ));
        });

        $event->setResponse($response);
    }

    public function onUpdate(MerchantEvent $event)
    {
        $route = $this->routeProvider->merchant_update;
        $version = $this->app['version'];

        $response = $route->process(function ($request) use ($event, $version) {
            $merchant = $event->getMerchant();

            $request->setHeaders(array(
                "Referer: {$merchant->getUuid()}",
                "Authorizsation: Basic {$merchant->getPassword()}"
            ));
            $request->setContent(array(
                'shopName' => $merchant->getName(),
                'shopUrl' => $merchant->getEndpoint(),
                'shopImageUrl' => $merchant->getImage(),
                'termsAndConditionsUrl' => $merchant->getTerms(),
                'policyUrl' => $merchant->getPolicy(),
                'webshopSystem' => $version
            ));
        });

        $event->setResponse($response);
    }

    public function onDelete(MerchantEvent $event)
    {
        $route = $this->routeProvider->merchant_delete;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->setHeaders(array(
                "Referer: {$merchant->getUuid()}",
                "Authorizsation: Basic {$merchant->getPassword()}"
            ));
        });

        $event->setResponse($response);
    }

    public function onPasswordUpdate(MerchantUpdatePasswordEvent $event)
    {
        $route = $this->routeProvider->merchant_password_update;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->setHeaders(array(
                "Referer: {$merchant->getUuid()}",
                "Authorizsation: Basic {$merchant->getPassword()}"
            ));
            $request->setContent(array(
                'newSecretKey' => base64_encode($merchant->getPassword())
            ));
        });

        $event->setResponse($response);
    }
}