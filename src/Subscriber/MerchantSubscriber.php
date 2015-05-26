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

            $request->addHeader("Referer: {$merchant->getHost()}");
            $request->setContent(array(
                'newPass' => base64_encode($merchant->getPassword()),
                'location' => $merchant->getPath()
            ));
        });

        $event->setResponse($response);
    }

    public function onDelete(MerchantEvent $event)
    {
        $route = $this->routeProvider->merchant_delete;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader("Referer: {$merchant->getHost()}");
            $request->setContent(array(
                'pass' => $merchant->getPassword(),
                'location' => $merchant->getPath()
            ));
        });

        $event->setResponse($response);
    }

    public function onPasswordUpdate(MerchantNewPasswordEvent $event)
    {
        $route = $this->routeProvider->merchant_password_update;

        $response = $route->process(function ($request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader("Referer: {$merchant->getHost()}");
            $request->setContent(array(
                'oldPass' => base64_encode($event->getOldPassword()),
                'newPass' => base64_encode($merchant->getPassword())
            ));
        });

        $event->setResponse($response);
    }
}