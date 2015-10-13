Responses/Endpoints
===================

Every single expected endpoint will be prefixed with the registered merchant_url_.
All Endpoints that must have hooks created in the mother system have a corresponding Presenter_.

.. _response-ping:

Ping Store
----------
.. http:get:: /expressly/api/ping

    Simple response message to note that the plugin has been installed.

    :resjson expressly: Stuff is happening!
    :resheader Content-Type: application/json

.. _response-popup:

Show Popup
----------
.. http:get:: /expressly/api/(string:uuid)

    Start the user migration process. This uri should invoke the :ref:`request-migration-popup` request.
    The Popup can be shown over any page you wish, we recommend appending the html to your homepage.

.. _response-migrate:

Migrate User
------------
.. http:get:: /expressly/api/(string:uuid)/migrate

    End of the user migration process. This uri should invoke the :ref:`request-migration-data` request.
    The method should add all data for the provided user to the store, and if provided, add a product and/or coupon to the users' cart.
    The user should be logged in directly after this migration, and a welcome email (if not part of your stores' initial flow) should be dispatched.


.. _response-user:

Get User
--------
.. http:get:: /expressly/api/user/(string:email)

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

    :resheader Content-Type: application/json

.. _response-batch-invoice:

Get Invoices for Customer Purchases
-----------------------------------
.. http:get:: /expressly/api/batch/invoice

    Given a list of date ranges, and emails checks to see if the associated campaign users have had any transactions during the specified period.

    .. code-block:: php

        $response

    :resheader Content-Type: application/json

.. _response-batch-customer:

Get Customers on Store
----------------------
.. http:get:: /expressly/api/batch/customer

    Given a list of emails, checks to see if a user has completed the migration process.

    :resheader Content-Type: application/json

.. [merchant_url] the location to execute/catch our paths;
    example: https://www.example.com/route?action=/expressly/api/ping

.. [Presenter] src/Presenter (namespace Expressly\Presenter)

.. [entities] src/Entity (namespace Expressly\Entity)