<?php

require_once __DIR__ . '/../vendor/autoload.php';

global $client;
$client = new Expressly\Client('phpunit', array(
    'external' => array(
        'hosts' => array(
            'default' => 'https://dev.expresslyapp.com/api/v2',
            'admin' => 'https://dev.expresslyapp.com/api/admin'
        )
    )
));
