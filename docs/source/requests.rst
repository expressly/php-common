Requests
========

All dispatchable requests will use one of the following external hosts.
Routing, and host definitions are defined in config.yml_.

.. _request-ping:

Ping
----
.. http:get:: /api/admin/ping

    Ping the API to see if the server is currently running.

    :reqheader Content-Type: application/json
    :resheader Content-Type: application/json

    **Example Response:**

    .. sourcecode:: http

        HTTP/1.1 200 OK
        Content-Type: application/json

        {
            "Server": "Live",
            "DB Status": "Live"
        }

    **PHP Implementation Example:**

    .. code-block:: php

        use Expressly\Event\ResponseEvent;
        use Expressly\Subscriber\UtilitySubscriber;

        $event = new ResponseEvent();
        $app['dispatcher']->dispatch(UtilitySubscriber::UTILITY_PING, $event);

        if ($event->isSuccessful()) {

        }

.. _request-merchant-register:

Register Merchant
-----------------
.. http:post:: /api/v2/plugin/merchant

    Register a store with the server.

    :reqjson string apiBaseUrl: see merchant_url_; if there isn't any special base routing the value should be the exact same as the shop url
    :reqjson string apiKey: api key retrieved from the Portal_ (see <https://buyexpressly.com/#/install>)
    :reqheader Content-Type: application/json
    :status 204: Registered successfully
    :status 400: Invalid data/request

    **PHP Implementation Example:**

    .. code-block:: php

        use Expressly\Event\MerchantEvent;
        use Expressly\Subscriber\MerchantSubscriber;

        $event = new MerchantEvent(...);
        $app['dispatcher']->dispatch(MerchantSubscriber::MERCHANT_REGISTER, $event);

        if ($event->isSuccessful()) {

        }

.. _request-migration-popup:

Get Campaign Migration Popup
----------------------------
.. http:get:: /api/v2/migration/(string:uuid)

    Request the popup to start a campaign migration for the unique user.

    :param uuid: Unique campaign migration uuid
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :resheader Content-Type: text/html
    :status 200: campaign migration found, html for popup returned
    :status 400: Invalid data/request


    **PHP Implementation Example:**

    .. code-block:: php

        use Expressly\Event\CustomerMigrateEvent;
        use Expressly\Subscriber\CustomerMigrationSubscriber;

        $event = new CustomerMigrateEvent(...);
        $app['dispatcher']->dispatch(CustomerMigrationSubscriber::CUSTOMER_MIGRATE_POPUP, $event);

        if ($event->isSuccessful()) {

        }

.. _request-migration-data:

Get Campaign Migration Data
---------------------------
.. http:get:: /api/v2/migration/(string:uuid)/user

    User has accepted popup, or been forced here directly; request, and start data migration.

    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :resheader Content-Type: application/json
    :status 200: Successfully returns user information
    :status 400: Invalid data/request

    **Example Response:**

    .. sourcecode:: http

        HTTP/1.1 200 OK
        Content-Type: application/json

        {
            "meta": {
                "locale": "UKR",
                "sender": "https://expresslyapp.com/api/v1/migration/{uuid}"
            },
            "data": {
                "email": "john.smith@gmail.com",
                "customerData": {
                    "firstName": "John",
                    "lastName": "Smith",
                    "gender": "M",
                    "billingAddress": 0,
                    "shippingAddress": 1,
                    "company": "Expressly",
                    "dob": "1987-08-07",
                    "taxNumber": "GB0249894821",
                    "onlinePresence": [
                        {
                            "field": "website",
                            "value": "http://www.myblog.com"
                        }
                    ],
                    "dateUpdated": "2015-07-10T11:42:00+01:00",
                    "emails": [
                        {
                            "email": "john.smith@gmail.com",
                            "alias": "default"
                        },
                        {
                            "email": "john@smithcorp.com",
                            "alias": "work"
                        }
                    ],
                    "phones": [
                        {
                            "type": "M",
                            "number": "020734581250",
                            "countryCode": 44
                        },
                        {
                            "type": "L",
                            "number": "020731443250",
                            "countryCode": 44
                        }
                    ],
                    "addresses": [
                        {
                            "firstName": "John",
                            "lastName": "Smith",
                            "address1": "12 Piccadilly",
                            "address2": "Room 14",
                            "city": "London",
                            "companyName": "WorkHard Ltd",
                            "zip": "W1C 34U",
                            "phone": 1,
                            "alias": "Work address",
                            "stateProvince": "LND",
                            "country": "GBR"
                        },
                        {
                            "firstName": "John C.",
                            "lastName": "Smith",
                            "address1": "23 Sallsberry Ave",
                            "address2": "Flat 3",
                            "city": "London",
                            "companyName": "",
                            "zip": "NW3 4HG",
                            "phone": 0,
                            "alias": "Home address",
                            "stateProvince": "LND",
                            "country": "GBR"
                        }
                    ]
                },
                "cart": {
                    "productId": "491",
                    "couponCode": "20OFF"
                }
            }
        }

    **PHP Implementation Example:**

    .. code-block:: php

        use Expressly\Event\CustomerMigrateEvent;
        use Expressly\Subscriber\CustomerMigrationSubscriber;

        $event = new CustomerMigrateEvent(...);
        $app['dispatcher']->dispatch(CustomerMigrationSubscriber::CUSTOMER_MIGRATE_DATA, $event);

        if ($event->isSuccessful()) {

        }

.. _request-migration-success:

Migration Success
-----------------
.. http:post:: /api/v2/migration/(string:uuid)/success

    Tells the server if the migration was successful, or if the user already existed on this store.

    :param uuid: Unique campaign migration uuid
    :reqjson enum status: enum to tell server is migration was successful; can be: 'migrated', 'existing_customer'
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :resheader Content-Type: application/json
    :status 200: Migration status acknowledged
    :status 400: Invalid data/request

    **Example Response:**

    .. sourcecode:: http

        HTTP/1.1 200 OK
        Content-Type: application/json

        {
            "success": "true",
            "msg": ""
        }

    **PHP Implementation Example:**

    .. code-block:: php

        use Expressly\Event\CustomerMigrateEvent;
        use Expressly\Subscriber\CustomerMigrationSubscriber;

        $event = new CustomerMigrateEvent(...);
        $app['dispatcher']->dispatch(CustomerMigrationSubscriber::CUSTOMER_MIGRATE_SUCCESS, $event);

        if ($event->isSuccessful()) {

        }

.. _request-banner-get:

Get Campaign Banner
-------------------
.. http:get:: /api/v2/banner/(string:uuid)?email=(string:email)

    If banner campaign is setup, get banner for a specified store, and email combination.

    :param uuid: Unique banner uuid
    :param email: Email for the currently logged in user
    :reqheader Content-Type: application/json
    :reqheader Authorization: Basic token
    :resheader Content-Type: application/json
    :status 200: Successfully found valid data for campaign banner
    :status 400: Invalid data/request

    **Example Response:**

    .. sourcecode:: http

        HTTP/1.1 200 OK
        Content-Type: application/json

        {
            "bannerImageUrl": "https://buyexpressly.com/assets/banner/awesome-banner.jpg",
            "migrationLink": "https://www.myblog.com/expressly/api/3aff1880-b0f5-45bd-8f33-247f55981f2c
        }

    **PHP Implementation Example:**

    .. code-block:: php

        use Expressly\Event\BannerEvent;
        use Expressly\Subscriber\BannerSubscriber;

        $event = new BannerEvent(...);
        $app['dispatcher']->dispatch(BannerSubscriber::BANNER_REQUEST, $event);

        if ($event->isSuccessful()) {

        }

.. [config.yml] src/Resources/config/config.yml
.. [merchant_url] the location to execute/catch our paths;
    example: https://www.example.com/route?action=/expressly/api/ping
.. [Portal] Expressly Portal: https://buyexpressly.com/#/portal/login