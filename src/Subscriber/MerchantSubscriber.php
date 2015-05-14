<?php

namespace Expressly\Subscriber;

use Expressly\Event\MerchantEvent;
use Expressly\Event\MerchantHostEvent;
use Expressly\Event\MerchantLocationEvent;
use Expressly\Event\MerchantNewPasswordEvent;
use Expressly\Event\PasswordedEvent;
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
            'merchant.host' => array('onHostSend', 0),
            'merchant.password.create' => array('onPasswordCreate', 0),
            'merchant.password.update' => array('onPasswordUpdate', 0)
        );
    }

    public function onHostSend(MerchantLocationEvent $event)
    {
        $route = $this->routeProvider->merchant_host_send;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader($event->getPassword());
            $request->setContent(array(
                'referer' => array(
                    'merchant' => $merchant->getHost()
                ),
                'query' => array(
                    'location' => $event->getLocation()
                )
            ));
        });

        $event->setResponse($response);
    }

    public function onPasswordCreate(PasswordedEvent $event)
    {
        $route = $this->routeProvider->merchant_password_update;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader($event->getPassword());
            $request->setContent(array(
                'referer' => array(
                    'merchant' => $merchant->getHost()
                ),
                'query' => array(
                    'newPass' => $event->getPassword()
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