<?php

namespace Expressly\Subscriber;

use Buzz\Client\FileGetContents as BuzzClient;
use Buzz\Message\Response as BuzzResponse;
use Expressly\Event\MerchantEvent;
use Expressly\Event\MerchantHostEvent;
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

    public function onHostSend(MerchantHostEvent $event)
    {

    }

    public function onPasswordCreate(MerchantEvent $event)
    {
        $merchant = $event->getMerchant();
        $password = $merchant->getPassword();
        $route = $this->routeProvider->merchant_password_update;
        $request = $route->getRequest();
        $response = new BuzzResponse();

        $request->addHeader($password);
        $request->setContent(array(
            'referer' => array(
                'merchant' => $merchant->getHost()
            ),
            'query' => array(
                'newPass' => $password
            )
        ));

        $client = new BuzzClient();
        $client->send($request, $response);

        return $response;
    }

    public function onPasswordUpdate(MerchantEvent $event)
    {
        $merchant = $event->getMerchant();
        $oldPassword = $event->getOldPassword();
        $route = $this->routeProvider->merchant_password_create;
        $request = $route->getRequest();
        $response = new BuzzResponse();

        $request->addHeader($oldPassword);
        $request->setContent(array(
            'referer' => array(
                'merchant' => $merchant->getHost()
            ),
            'query' => array(
                'oldPass' => $oldPassword,
                'newPass' => $merchant->getPassword()
            )
        ));

        $client = new BuzzClient();
        $client->send($request, $response);

        return $response;
    }
}