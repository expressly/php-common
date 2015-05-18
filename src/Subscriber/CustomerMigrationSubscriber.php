<?php

namespace Expressly\Subscriber;

use Buzz\Message\Request as BuzzRequest;
use Expressly\Event\CustomerMigrateEvent;
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
            'customer.migrate.complete' => array('onComplete', 0)
        );
    }

    /*
     * Initial request of migrate customer request flow
     * Returns JSON structured HTML to display to the user; requires user action to continue
     */
    public function onStart(CustomerMigrateEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_start;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));

        $response = $route->process(function (BuzzRequest $request) use ($event) {
            $request->addHeader($event->getPassword());
        });

        $event->setResponse($response);
    }

    /*
     * Secondary request of migrate customer request flow
     * If user agrees to conditions: request cart, and coupon information
     */
    public function onComplete(CustomerMigrateEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_complete;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));

        $response = $route->process(function (BuzzRequest $request) use ($event) {
            $request->addHeader($event->getPassword());
        });

        $event->setResponse($response);
    }
}