<?php

namespace Expressly\Subscriber;

use Buzz\Message\Request as BuzzRequest;
use Expressly\Event\CustomerMigrateEvent;
use Expressly\Event\PasswordedEvent;
use Silex\Application;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerMigrationSubscriber implements EventSubscriberInterface
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
            'customer.migrate.start' => array('onStart', 0),
            'customer.migrate.cart' => array('onGetCart', 0),
            'customer.migrate.send' => array('onSendRequest', 0)
        );
    }

    /*
     * Initial request of migrate customer request flow
     * Returns JSON structured HTML to display to the user; requires user action to continue
     */
    public function onMigrateStart(PasswordedEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_start;

        return $route->process(function (BuzzRequest $request) use ($event) {
            $request->addHeader($event->getPassword());
        });
    }

    /*
     * Secondary request of migrate customer request flow
     * If user agrees to conditions: request cart, and coupon information
     */
    public function onMigrateCart(PasswordedEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_cart;

        return $route->process(function (BuzzRequest $request) use ($event) {
            $request->addHeader($event->getPassword());
        });
    }

    /*
     * Requested when hit: http://<host>/expressly/api/user/<email>
     * To be sent when requested, by master API, for a user object to give to another shop
     */
    public function onSendRequest(CustomerMigrateEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_send;

        return $route->process(function (BuzzRequest $request) use ($event) {
            $request->addHeader($event->getPassword());
            $request->setContent(array(
                'email' => $event->getEmail(),
                'userReference' => $event->getReference(),
                'customerData' => $event->getCustomer()->toArray()
            ));
        });
    }
}