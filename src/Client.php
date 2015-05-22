<?php

namespace Expressly;

use Silex\Application;

class Client
{
    private $app;

    public function __construct()
    {
        $this->app = require __DIR__ . '/../bootstrap/bootstrap.php';
    }

    public function getApp()
    {
        return $this->app;
    }
}