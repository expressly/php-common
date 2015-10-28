Overview
========

.. _overview-requirements:

Requirements
------------
* PHP 5.3+
* composer_

All composer dependencies are included in the Expressly provided integration releases on GitHub.

.. _overview-include:

Include
-------
Inside your composer.json, you need to include:

.. code-block:: javascript

    "require": {
        "expressly/php-common": "1.1.6"
    },
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/expressly/php-common"
        }
    ]

.. _overview-configuration:

Configuration
-------------
All configuration values associated with the repository are contained within config.yml_.

To act in development mode, the following block inside the config.yml_ should be changed from:

.. code-block:: yaml

    external:
        hosts:
            default: http://prod.expresslyapp.com/api/v1
            admin: http://prod.expresslyapp.com/api/admin

to

.. code-block:: yaml

    external:
        hosts:
            default: http://dev.expresslyapp.com/api/v1
            admin: http://dev.expresslyapp.com/api/admin

.. _overview-client:

Create a Client
---------------
In order to make use of the DI_ container, to include, override, or extend any code we provide, a new instance of the Expressly Client is required.

.. code-block:: php

    use Expressly;

    /*
     * $merchantType is a string to help us identify your system type in logs.
     * Example constants in: Expressly\Entity\MerchantType
     */
    $client = new Client($merchantType, array());
    $app = $client->getApp();

.. _overview-checklist:

Checklist
---------
For a working Expressly integration, using this library, the following need to be checked off:

- :ref:`overview-include` the project via composer (or alternative).
- Change :ref:`overview-configuration` if needed (for development purposes).
- :ref:`overview-client`.
- Create a localized MerchantProvider: must extend MerchantProviderInterface_, and register it with the application:

.. code-block:: php

    use Expressly\Provider\MerchantProviderInterface;

    class MyMerchantProvider implements MerchantProviderInterface {
        // your implementation
    }

    $app['merchant.provider'] = $app->share(function ($app) {
        return new MyMerchantProvider();
    });

Roadmap
-------
- Dependency drill down: restructure so Pimple_ is the base product instead of Silex_.
- Offer resolver data handling as a closure pass-through.

.. [composer] PHP package manager: https://getcomposer.org/
.. [config.yml] src/Resources/config/config.yml
.. [Silex] Silex PHP Microframework: http://silex.sensiolabs.org/
.. [Pimple] DI_ implementation: http://pimple.sensiolabs.org/
.. [DI] Dependency Injection
.. [MerchantProviderInterface] src/Provider/MerchantProviderInterface.php (Expressly\Provider\MerchantProviderInterface)