<?php

$app = new Expressly\Client('phpunit', array(
    'external' => array(
        'hosts' => array(
            'default' => 'https://dev.expresslyapp.com/api/v2',
            'admin' => 'https://dev.expresslyapp.com/api/admin'
        )
    )
));
