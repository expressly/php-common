<?php

namespace Expressly\Subscriber;

use Buzz\Message\Request as BuzzRequest;
use Expressly\Event\AcknowledgeableEvent;
use Expressly\Event\CustomerUpdateEvent;
use Expressly\Event\OrderUpdateEvent;
use Silex\Application;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerSubscriber implements EventSubscriberInterface
{
    private $app;
    private $routeProvider;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->routeProvider = $this->app['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            'customer.update' => array('onUpdate', 0),
            'customer.reset' => array('onReset', 0),
            'customer.order' => array('onOrderRequest', 0)
        );
    }

    /*
     * To be sent when requested for up to date user call
     */
    public function onUpdate(CustomerUpdateEvent $event)
    {
        $route = $this->routeProvider->customer_update;

        $response = $route->process(function (BuzzRequest $request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader(array('Referer' => $merchant->getHost()));
            $request->setContent(array(
                'updated' => $event->getLastUpdated()
            ));
        });

        $event->setResponse($response);
    }

    /*
     * Send acknowledgement to the master server regarding (un)successful deletion
     */
    public function onReset(AcknowledgeableEvent $event)
    {
        $route = $this->routeProvider->customer_reset;

        $response = $route->process(function (BuzzRequest $request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader(array('Referer' => $merchant->getHost()));
            $request->setContent(array(
                'acknowledged' => $event->getAcknowledge()
            ));
        });

        $event->setResponse($response);
    }

    /*
     * Dispatched on request of order updates for given user
     */
    public function onOrderRequest(OrderUpdateEvent $event)
    {
        $route = $this->routeProvider->customer_order;

        $response = $route->process(function (BuzzRequest $request) use ($event) {
            $merchant = $event->getMerchant();

            $request->addHeader(array('Referer' => $merchant->getHost()));
            $request->setContent(array(
                'email' => $event->getEmail(),
                'order' => $event->getOrder()->toArray()
            ));
        });

        $event->setResponse($response);
    }
}