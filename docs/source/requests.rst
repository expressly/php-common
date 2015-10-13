Requests
========

All dispatchable requests will use one of the following external hosts.
Routing, and host definitions are defined in config.yml_.

.. code-block:: yaml

    external:
        hosts:
            default: http://prod.expresslyapp.com/api/v1
            admin: http://prod.expresslyapp.com/api/admin

.. _request-ping:

Ping
----
.. http:get:: /api/admin/ping

    Ping the API to see if the server is currently running.

    .. code-block:: php

        use Expressly\Event\ResponseEvent;
        use Expressly\Subscriber\UtilitySubscriber;

        $event = new ResponseEvent();
        $app['dispatcher']->dispatch(UtilitySubscriber::UTILITY_PING, $event);

        if ($event->isSuccessful()) {

        }

    :reqheader Content-Type: application/json
    :resheader Content-Type: application/json

.. _request-merchant-register:

Register Merchant
-----------------
.. http:post:: /api/v1/register

    Register a store with the server.

    .. code-block:: php

        use Expressly\Event\MerchantEvent;
        use Expressly\Subscriber\MerchantSubscriber;

        $event = new MerchantEvent(...);
        $app['dispatcher']->dispatch(MerchantSubscriber::MERCHANT_REGISTER, $event);

        if ($event->isSuccessful()) {

        }

    :reqjson string shopName: shop name
    :reqjson string shopUrl: shop url (https://www.example.com)
    :reqjson string apiBaseUrl: see merchant_url_; if there isn't any special base routing the value should be the exact same as the shop url
    :reqjson string shopImageUrl: logo url
    :reqjson string termsAndConditionsUrl: url to terms, and conditions page
    :reqjson string policyUrl: url to privacy policy page
    :reqjson string pluginVersion: plugin version (current: v1)
    :reqheader Content-Type: application/json
    :status 200:
    :status 400:

.. _request-merchant-update:

Update Merchant
---------------
.. http:post:: /api/v1/merchant/(string:uuid)/update

    Update details for an existing store.

    .. code-block:: php

        use Expressly\Event\PasswordedEvent;
        use Expressly\Subscriber\MerchantSubscriber;

        $event = new PasswordedEvent(...);
        $app['dispatcher']->dispatch(MerchantSubscriber::MERCHANT_UPDATE, $event);

        if ($event->isSuccessful()) {

        }

    :param uuid: Unique merchant uuid
    :reqjson string shopName: shop name
    :reqjson string shopUrl: shop url (https://www.example.com)
    :reqjson string apiBaseUrl: see merchant_url_; if there isn't any special base routing the value should be the exact same as the shop url
    :reqjson string shopImageUrl: logo url
    :reqjson string termsAndConditionsUrl: url to terms, and conditions page
    :reqjson string policyUrl: url to privacy policy page
    :reqjson string pluginVersion: plugin version (current: v1)
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :status 200:
    :status 400:

.. _request-merchant-remove:

Remove Merchant
---------------
.. http:post:: /api/v1/merchant/(string:uuid)/uninstall

    Remove store from the expressly system.

    .. code-block:: php

        use Expressly\Event\PasswordedEvent;
        use Expressly\Subscriber\MerchantSubscriber;

        $event = new PasswordedEvent(...);
        $app['dispatcher']->dispatch(MerchantSubscriber::MERCHANT_DELETE, $event);

        if ($event->isSuccessful()) {

        }

    :param uuid: Unique merchant uuid
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :status 200:
    :status 400:

.. _request-migration-popup:

Get Campaign Migration Popup
----------------------------
.. http:get:: /api/v1/migration/(string:uuid)

    Request the popup to start a campaign migration for the unique user.

    .. code-block:: php

        use Expressly\Event\CustomerMigrateEvent;
        use Expressly\Subscriber\CustomerMigrationSubscriber;

        $event = new CustomerMigrateEvent(...);
        $app['dispatcher']->dispatch(CustomerMigrationSubscriber::CUSTOMER_MIGRATE_POPUP, $event);

        if ($event->isSuccessful()) {

        }

    :param uuid: Unique campaign migration uuid
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :resheader Content-Type: text/html
    :status 200: campaign migration found, html for popup returned
    :status 400:

.. _request-migration-data:

Get Campaign Migration Data
---------------------------
.. http:get:: /api/v1/migration/(string:uuid)/user

    User has accepted popup, or been forced here directly; request, and start data migration.

    .. code-block:: php

        use Expressly\Event\CustomerMigrateEvent;
        use Expressly\Subscriber\CustomerMigrationSubscriber;

        $event = new CustomerMigrateEvent(...);
        $app['dispatcher']->dispatch(CustomerMigrationSubscriber::CUSTOMER_MIGRATE_DATA, $event);

        if ($event->isSuccessful()) {

        }

    :param uuid: Unique campaign migration uuid
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :resheader Content-Type: application/json
    :status 200:
    :status 400:

.. _request-migration-success:

Migration Success
-----------------
.. http:post:: /api/v1/migration/(string:uuid)/success

    Tells the server if the migration was successful, or if the user already existed on this store.

    .. code-block:: php

        use Expressly\Event\CustomerMigrateEvent;
        use Expressly\Subscriber\CustomerMigrationSubscriber;

        $event = new CustomerMigrateEvent(...);
        $app['dispatcher']->dispatch(CustomerMigrationSubscriber::CUSTOMER_MIGRATE_SUCCESS, $event);

        if ($event->isSuccessful()) {

        }

    :param uuid: Unique campaign migration uuid
    :reqjson enum status: enum to tell server is migration was successful; can be: 'migrated', 'existing_customer'
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :status 200:
    :status 400:

.. _request-banner-get:

Get Campaign Banner
-------------------
.. http:get:: /api/v1/banner/(string:uuid)?email=(string:email)

    If banner campaign is setup, get banner for a specified store, and email combination.

    .. code-block:: php

        use Expressly\Event\BannerEvent;
        use Expressly\Subscriber\BannerSubscriber;

        $event = new BannerEvent(...);
        $app['dispatcher']->dispatch(BannerSubscriber::BANNER_REQUEST, $event);

        if ($event->isSuccessful()) {

        }

    :param uuid: Unique banner uuid
    :param email: Email for the currently logged in user
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :status 200:
    :status 400:

.. [config.yml] src/Resources/config/config.yml

.. [merchant_url] the location to execute/catch our paths;
    example: https://www.example.com/route?action=/expressly/api/ping