<?php

namespace Expressly\Subscriber;

use Expressly\Event\CustomerMigrateEvent;
use Pimple\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CustomerMigrationSubscriber implements EventSubscriberInterface
{
    private $container;
    private $routeProvider;

    const CUSTOMER_MIGRATE_POPUP = 'customer.migrate.popup';
    const CUSTOMER_MIGRATE_DATA = 'customer.migrate.data';
    const CUSTOMER_MIGRATE_SUCCESS = 'customer.migrate.success';

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->routeProvider = $this->container['external_route.provider'];
    }

    public static function getSubscribedEvents()
    {
        return array(
            self::CUSTOMER_MIGRATE_POPUP => array('getPopup', 0),
            self::CUSTOMER_MIGRATE_DATA => array('getData', 0),
            self::CUSTOMER_MIGRATE_SUCCESS => array('onSuccess', 0)
        );
    }

    /**
     * Initial request of migrate customer request flow
     * Response filled with HTML to display to the user; requires user action to continue
     * @codeCoverageIgnore
     */
    public function getPopup(CustomerMigrateEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_popup;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));

        $response = $route->process(function ($request) use ($event) {
            $request->addHeader($event->getBasicHeader());
        });

        $event->setResponse($response);
    }

    /**
     * Secondary request of migrate customer request flow
     * If user agrees to conditions: request cart, and coupon information
     * @codeCoverageIgnore
     */
    public function getData(CustomerMigrateEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_data;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));

        $response = $route->process(function ($request) use ($event) {
            $request->addHeader($event->getBasicHeader());
        });

        $event->setResponse($response);
    }

    /**
     * Additional third request to notify the application that we've added the user successfully
     * @codeCoverageIgnore
     */
    public function onSuccess(CustomerMigrateEvent $event)
    {
        $route = $this->routeProvider->customer_migrate_success;
        $route->setParameters(array(
            'uuid' => $event->getUuid()
        ));

        $response = $route->process(function ($request) use ($event) {
            $request->addHeader($event->getBasicHeader());

            $request->setContent(array(
                'status' => $event->getStatus()
            ));
        });

        $event->setResponse($response);
    }
}