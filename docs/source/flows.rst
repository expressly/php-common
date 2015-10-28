Flows
=====

For all flows, the following Actors have been used:

SERVER
    Expressly API server;
STORE
    The store Expressly is being configured with;
CUSTOMER
    The customer interacting with the store.

.. _flow-merchant-registration:

Merchant Registration
---------------------

**Pre-conditions:**

- Expressly plugin has been integrated, ticking all boxes of :ref:`overview-checklist`.
- API key exists, and has been created on the Portal_ (see <https://buyexpressly.com/#/install>).

**Main Flow:**

1. STORE calls :ref:`request-merchant-register` with appropriate body, and header.
2. SERVER pings store to make sure you have the plugin installed correctly.
3. SERVER returns successfully to STORE

**Alternate Flows:**

3-1. SERVER cannot ping STORE, returns error message.

.. _flow-merchant-update:

Merchant Update
---------------

**Pre-conditions:**

- :ref:`flow-merchant-registration`.

**Main Flow:**

1. STORE calls :ref:`request-merchant-update` with appropriate body.
2. SERVER stores updated values, and returns success body.

**Alternate Flows:**

2-1. Data does not conform to validation, SERVER returns appropriate error body.

.. _flow-migration:

User Campaign Migration
-----------------------

**Pre-conditions:**

- :ref:`flow-merchant-registration`.
- Campaign has been created on the Portal_.

**Main Flow:**

1. CUSTOMER navigates to provided link with unique uuid attached (:ref:`response-popup`).
2. STORE requests popup for unique uuid (:ref:`request-migration-popup`).
3. SERVER returns popup html rendered for the given campaign, and CUSTOMER.
4. STORE renders html atop any given store page (e.g. homepage).
5. CUSTOMER accepts terms & conditions, and privacy policy provided by pressing 'ok'.
6. STORE navigates to :ref:`response-migrate`, and requests information.
7. SERVER returns information associated with CUSTOMER.
8. STORE adds customer to their store; adds product, and coupon (if provided, and supported) to cart.
9. STORE tells SERVER that CUSTOMER has been migrated correctly (:ref:`request-migration-success`).
10. STORE logs user in, and navigates to homepage.

**Alternate Flows:**

7-1. CUSTOMER already exists, STORE tells SERVER that customer has been migrated previously (:ref:`request-migration-success`).
8-1. STORE adds product, and coupon (if provided, and supported) to cart.
9-1. STORE shows CUSTOMER message that they already exist, asking if they want to go to the login page.

.. _flow-bulk-invoice:

Check Purchases
---------------

**Pre-conditions:**

- :ref:`flow-merchant-registration`.

**Main Flow:**

1. SERVER requests endpoint (:ref:`response-batch-invoice`) with JSON of emails, and date period to STORE.
2. STORE compares emails, and period to gather purchase information for given CUSTOMERs'.
3. STORE returns compiled data to SERVER.

.. _flow-bulk-customers:

Check Customer Migration
------------------------

**Pre-conditions:**

- :ref:`flow-merchant-registration`.

**Main Flow:**

1. SERVER requests endpoint (:ref:`response-batch-customer`) with JSON of emails to STORE.
2. STORE compares emails to determine whether CUSTOMER has been migrated.
3. STORE returns compiled data to SERVER.

.. _flow-banner:

Campaign Banner
---------------

**Pre-conditions:**

- :ref:`flow-merchant-registration`.
- Campaign for serving banners has been created on the Portal_.
- CUSTOMER is logged in.

**Main Flow:**

1. STORE requests banner from SERVER (:ref:`request-banner-get`).
2. SERVER returns image, and url.
3. STORE displays banner on page (in the location it was called from) on page render.
4. Banner clicked on, redirecting to associated route starting :ref:`flow-migration` off-site.


.. [Portal] Expressly management Portal: https://buyexpressly.com/#/portal/login