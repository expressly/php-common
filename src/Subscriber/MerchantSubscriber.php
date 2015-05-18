<?php

namespace Expressly\Subscriber;

use Expressly\Event\MerchantEvent;
use Expressly\Event\MerchantNewPasswordEvent;
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
            'merchant.delete' => array('onDelete', 0),
            'merchant.password.update' => array('onPasswordUpdate', 0)
        );
    }

    public function onRegister(MerchantEvent $event)
    {
        $route = $this->routeProvider->merchant_register;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->setContent(array(
                'referer' => array(
                    'merchant' => $merchant->getHost()
                ),
                'query' => array(
                    'newPass' => $merchant->getPassword(),
                    'location' => $merchant->getPath()
                )
            ));
        });

        $event->setResponse($response);
    }

    public function onDelete(MerchantEvent $event)
    {
        $route = $this->routeProvider->merchant_delete;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->setContent(array(
                'referer' => array(
                    'merchant' => $merchant->getHost()
                ),
                'query' => array(
                    'pass' => $merchant->getPassword(),
                    'location' => $merchant->getPath()
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