<?php

namespace Expressly\Subscriber;

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
            'customer.migrate.complete' => array('onComplete', 0),
            'customer.migrate.success' => array('onSuccess', 0)
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

        $response = $route->process();

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

        $response = $route->process();

        $event->setResponse($response);
    }

    /*
     * Additional third request to notify the application that we've added the user successfully
     */
    public function onSuccess(CustomerMigrateEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_success;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));

        $response = $route->process();

        $event->setResponse($response);
    }
}