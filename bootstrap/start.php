<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// After request
$app->after(function (Request $request, Response $response) {
    $response->headers->add(array('X-Powered-By' => 'Copious amounts of Alcohol; mostly Beer.'));
});