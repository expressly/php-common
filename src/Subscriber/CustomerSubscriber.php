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

        return $route->process(function (BuzzRequest $request) use ($event) {
            $request->addHeader($event->getPassword());
            $request->setContent(array(
                'updated' => $event->getLastUpdated()
            ));
        });
    }

    /*
     * Send acknowledgement to the master server regarding (un)successful deletion
     */
    public function onReset(AcknowledgeableEvent $event)
    {
        $route = $this->routeProvider->customer_reset;

        return $route->process(function (BuzzRequest $request) use ($event) {
            $request->addHeader($event->getPassword());
            $request->setContent(array(
                'acknowledged' => $event->getAcknowledge()
            ));
        });
    }

    /*
     * Dispatched on request of order updates for given user
     */
    public function onOrderRequest(OrderUpdateEvent $event)
    {
        $route = $this->routeProvider->customer_order;

        return $route->process(function (BuzzRequest $request) use ($event) {
            $request->addHeader($event->getPassword());
            $request->setContent(array(
                'email' => $event->getEmail(),
                'order' => $event->getOrder()->toArray()
            ));
        });
    }
}