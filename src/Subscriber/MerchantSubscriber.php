<?php

namespace Expressly\Subscriber;

use Expressly\Event\MerchantEvent;
use Expressly\Event\MerchantHostEvent;
use Expressly\Event\MerchantLocationEvent;
use Expressly\Event\MerchantNewPasswordEvent;
use Expressly\Event\MerchantRegisterEvent;
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
            'merchant.register' => array('onCreate', 0),
            'merchant.password.update' => array('onPasswordUpdate', 0)
        );
    }

    public function onRegister(MerchantRegisterEvent $event)
    {
        $route = $this->routeProvider->merchant_register;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->setContent(array(
                'referer' => array(
                    'merchant' => $merchant->getHost()
                ),
                'query' => array(
                    'newPass' => $event->getPassword(),
                    'location' => $event->getLocation()
                )
            ));
        });

        $event->setResponse($response);
    }

    public function onPasswordUpdate(MerchantNewPasswordEvent $event)
    {
        $route = $this->routeProvider->merchant_password_create;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader($event->getOldPassword());
            $request->setContent(array(
                'referer' => array(
                    'merchant' => $merchant->getHost()
                ),
                'query' => array(
                    'oldPass' => $event->getOldPassword(),
                    'newPass' => $merchant->getPassword()
                )
            ));
        });

        $event->setResponse($response);
    }
}