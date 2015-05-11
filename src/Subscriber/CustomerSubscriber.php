<?php

namespace Expressly\Subscriber;

use Buzz\Client\FileGetContents as BuzzClient;
use Buzz\Message\Response as BuzzResponse;
use Expressly\Event\AcknowledgeableEvent;
use Expressly\Event\CustomerMigrateEvent;
use Expressly\Event\CustomerUpdateEvent;
use Expressly\Event\OrderUpdateEvent;
use Silex\Application;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerSubscriber implements EventSubscriberInterface
{
    private $app;
    private $routeProvider;
    private $merchantProvider;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->routeProvider = $this->app['external_route.provider'];
        $this->merchantProvider = $this->app['merchant.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            'customer.migrate' => array('onMigrate', 0),
            'customer.update' => array('onUpdate', 0),
            'customer.reset' => array('onReset', 0),
            'customer.order' => array('onOrderRequest', 0)
        );
    }

    public function onMigrate(CustomerMigrateEvent $event)
    {
        $route = $this->routeProvider->customer_migrate;
        $merchant = $this->merchantProvider->getMerchant();
        $request = $route->getRequest();
        $response = new BuzzResponse();

        $request->addHeader($merchant->getPassword());
        $request->setContent(array(
            'email' => $event->getEmail(),
            'userReference' => $event->getReference(),
            'customerData' => $event->getCustomer()->toArray()
        ));

        $client = new BuzzClient();
        $client->send($request, $response);

        return $response;
    }

    public function onUpdate(CustomerUpdateEvent $event)
    {

    }

    public function onReset(AcknowledgeableEvent $event)
    {

    }

    public function onOrderRequest(OrderUpdateEvent $event)
    {
        $route = $this->routeProvider->customer_order;
        $merchant = $this->merchantProvider->getMerchant();
        $request = $route->getRequest();
        $response = new BuzzResponse();

        $request->addHeader($merchant->getPassword());
        $request->setContent(array(
            'email' => $event->getEmail(),
            'order' => $event->getOrder()->toArray()
        ));

        $client = new BuzzClient();
        $client->send($request, $response);

        return $response;
    }
}