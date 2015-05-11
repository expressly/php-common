## Introduction
Common Expressly library. This library is written in Silex, with additional Symfony2 components, and Buzz to dispatch requests. All logic is handled by this library; child libraries should only wrap, and populate the existing functionality.

## Style
All code must follow `PSR-1/PSR-2` style guidelines.

## Requirements
- PHP 5.3+
- composer (to be bundled)
- Apache
- nginx (to be done by myself)

## Installation
Basic installation:

- `git clone git@github.com:expressly/php-common.git`
- `composer install`
- `chmod -R 777 ./storage`

Or, require the git repository as a composer dependency to the child library.

There are a few sections of the library that must be populated, or overwritten for proper functionality.  
Note: All references to an `$app` are directly linked to an instance of `Silex\Application`. This instance is returned from the `Expressly\Client`.

### Database
As we require the storage of merchant preferences, some settings must be updated, or overwritten.
There is a Doctrine mapped fallback for `Expressly\Entity\Merchant` which utilizes default configuration values. If the eCommerce shop in question doesn't provide a database access API, the in-place fall-back is to be used.
The fallback will be used by default, configuration values must be updated. These values are located in `/src/Resources/config/config.yml`, and have a yaml structure of:

    database:
        driver: pdo_mysql
        host: 127.0.0.1
        dbname: expressly
        user: root
        password: ''
        
And

    table:
        merchant: expressly_preferences
        
To overwrite in PHP, use the following command as an example:
    
    $app['config']['database']['dbname'] = 'expressly';
    
The following are to be saved in the merchants' database:
- Hostname
- Password (if not provided when calling `setPassword()`, a new password will be generated)
- Offer: whether to show offers, or not
- Redirect destination, if shop requires as such    

### Incoming Requests
Incoming request must be handled by the child library. The following requests will be received, and must be handled:

    ping:
        pattern: /expressly/api/ping
        method: [GET]
        event: utility.ping
    
    customer migrate:
        pattern: /expressly/api/user/{email}
        method: [GET]
        event: customer.migrate
    
    customer update:
        pattern: /expressly/api/user/{email}
        method: [POST]
        event: customer.update
    
    customer reset:
        pattern: /expressly/api/user/{email}/delete
        method: [POST]
        event: customer.reset
    
    customer order:
        pattern: /expressly/api/user/{email}/order
        method: [GET]
        event: customer.order


### Outgoing Requests
All outgoing requests are sent via Buzz. These definitions are made in `/src/Resources/config/config.yml` in following structure:

    external:
        host: https://expresslyapp.com/api/v1
        routes:
            route_name:
                method: METHOD
                uri: /

All logic for outgoing events is handled by this library. Event are in place to dispatch requests, the incoming information must be populated. All available events definitions are located in `Expressly\Subscriber\*::getSubscribedEvents()`. To call these events, please repurpose the following:

    $app['dispatcher']->dispatch('customer.migrate', new Expressly\Event\CustomerMigrateEvent($customer, $email, $reference));
    
## Javascript
Using the respective shop's inclusion method, the `/src/Resources/js/expressly.js` file must be included on the page. Upon including the file, an AJAX request will be auto-executed to request the modal from our servers.
