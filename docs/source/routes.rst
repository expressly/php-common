Routes
======

All routes are dispatched using the included RouteResolver_. If you platform has a built in parser, the associated regex is attached (statically) to each route in the Expressly\\Routes namespace.
The RouteResolver_ will check if the required header(s), method, and route were passed through, and return the valid data (if any) inside a matched Route_ object, or null.

.. code-block:: php

    $query = '/expressly/api/*';
    $route = $app['route.resolver']->process($query);

Every single expected endpoint will be prefixed with the registered merchant_url_.
All Endpoints that must have hooks created in the mother system have a corresponding Presenter_.

.. _response-ping:

Ping Store
----------
.. http:get:: /expressly/api/ping

    :Route class:
        Expressly\\Route\\Ping

    Simple response message to note that the plugin has been installed.

    :reqheader Content-Type: application/json
    :resjson expressly: Stuff is happening!
    :resheader Content-Type: application/json

.. _response-popup:

Show Popup
----------
.. http:get:: /expressly/api/(string:uuid)

    :Route class:
        Expressly\\Route\\CampaignPopup

    Start the user migration process. This uri should invoke the :ref:`request-migration-popup` request.
    The Popup can be shown over any page you wish, we recommend appending the html to your homepage.

    :reqheader Authorization: Basic token
    :resheader Content-Type: text/html

.. _response-migrate:

Migrate User
------------
.. http:get:: /expressly/api/(string:uuid)/migrate

    :Route class:
        Expressly\\Route\\CampaignMigration

    End of the user migration process. This uri should invoke the :ref:`request-migration-data` request.
    The method should add all data for the provided user to the store, and if provided, add a product and/or coupon to the users' cart.
    The user should be logged in directly after this migration, and a welcome email (if not part of your stores' initial flow) should be dispatched.

    :reqheader Authorization: Basic token
    :resheader Content-Type: text/html

.. _response-user:

Get User
--------
.. http:get:: /expressly/api/user/(string:email)

    :Route class:
        Expressly\\Route\\UserData

    Returns user, via your application facilities, conforming to our defined entities_.

    .. code-block:: php

        $customer = new Customer();
        /*
         * fill in as many applicable setters as possible
         * $customer
         *      ->setFirstName('John')
         *      ->setLastName('Smith');
         */
        $response = new CustomerMigratePresenter($merchant, $customer, $email, $id);
        // display content however your application prefers
        echo json_encode($response->toArray());

    **Example Response:**

    .. sourcecode:: http

        HTTP/1.1 200 OK
        Content-Type: application/json

        {
            "meta": {
                "locale": "UKR",
                "sender": "https://yourstore.com/",
                "issuerData": []
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
                            "value": "www.myblog.com"
                        }
                    ],
                    "dateUpdated": "2015-07-10T11:42:00+01:00",
                    "dateLastOrder": "2015-07-10T11:42:00+01:00",
                    "numberOrdered": 5,
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
                }
            }
        }

    :reqheader Authorization: Basic token
    :reqheader Content-Type: application/json
    :resheader Content-Type: application/json

.. _response-batch-invoice:

Invoices for Customer Purchases
-------------------------------
.. http:post:: /expressly/api/batch/invoice

    :Route class:
        Expressly\\Route\\BatchInvoice

    Given a list of date ranges, and emails checks to see if the associated campaign users have had any transactions during the specified period.

    .. code-block:: php

        use Expressly\Entity\Invoice;
        use Expressly\Entity\Order;
        use Expressly\Presenter\BatchInvoicePresenter;

        $invoices = array();

        foreach ($json->customers as $customer) {
            $invoice = new Invoice();
            $invoice->setEmail($customer->email);

            foreach ($userOrders as $userOrder) {
                $order = new Order();
                $order
                    ->setId($userOrder->getId())
                    ->setDate(new \DateTime($userOrder->getOrderDate())
                    ->setItemCount($userOrder->getQuantity())
                    ->setTotal($userOrder->getTotalPreTax(), $userOrder->getTax())
                    ->setCoupon($userOrder->getCoupon());

                $invoice->addOrder($order);
            }

            $invoices[] = $invoice;
        }

        $presenter = new BatchInvoicePresenter($invoices);
        // display content however your application prefers
        echo json_encode($presenter->toArray());

    **Example Request:**

    .. sourcecode:: http

        POST /expressly/api/batch/invoice
        Host: prod.expresslyapp.com
        Authorization: Basic token

        {
            "customers": [
                {
                    "email": "john.smith@gmail.com",
                    "from": "2015-07-01T00:00:00+00:00",
                    "to": "2015-08-01T00:00:00+00:00"
                }
            ]
        }

    **Example Response:**

    .. sourcecode:: http

        HTTP/1.1 200 OK
        Content-Type: application/json

        {
            "invoices": [
                {
                    "email": "john.smith@gmail.com",
                    "orderCount": 1,
                    "preTaxTotal": 100.00,
                    "tax": 10.00,
                    "orders": [
                        {
                            "id": "ORDER-5321311",
                            "date": "2015-07-10T11:42:00+01:00",
                            "itemCount": 2,
                            "coupon": "",
                            "currency": "GBP",
                            "preTaxTotal": 100.00,
                            "postTaxTotal": 110.00,
                            "tax": 10.00
                        }
                    ]
                }
            ]
        }

    :reqheader Authorization: Basic token
    :reqheader Content-Type: application/json
    :resheader Content-Type: application/json

.. _response-batch-customer:

Customers on Store
------------------
.. http:post:: /expressly/api/batch/customer

    :Route class:
        Expressly\\Route\\BatchCustomer

    Given a list of emails, checks to see if a user has completed the migration process.

    .. code-block:: php

        use Expressly\Presenter\BatchCustomerPresenter;

        $users = array(
            'existing' => array(),
            'deleted' => array(),
            'pending' => array()
        );

        foreach ($json->emails as $email) {
            // add user to certain sector of array, depending on state
        }

        $presenter = new BatchCustomerPresenter($users);
        // display content however your application prefers
        echo json_encode($presenter->toArray());

    **Example Request:**

    .. sourcecode:: http

        POST /expressly/api/batch/customer
        Host: prod.expresslyapp.com
        Authorization: Basic token

        {
            "emails": [
                "john.smith@gmail.com"
            ]
        }

    **Example Response:**

    .. sourcecode:: http

        HTTP/1.1 200 OK
        Content-Type: application/json

        {
            "existing": [
                "john.smith@gmail.com"
            ],
            "deleted": [],
            "pending": []
        }

    :reqheader Authorization: Basic token
    :reqheader Content-Type: application/json
    :resheader Content-Type: application/json

.. [RouteResolver] src/Resolver/RouteResolver (namespace Expressly\Resolver\RouteResolver)
.. [merchant_url] the location to execute/catch our paths;
    example: https://www.example.com/route?action=/expressly/api/ping
.. [Route] src/Entity/Route (namespace Expressly\Entity\Route)
.. [Presenter] src/Presenter (namespace Expressly\Presenter)
.. [entities] src/Entity (namespace Expressly\Entity)