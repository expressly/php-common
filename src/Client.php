<?php

namespace Expressly;

class Client
{
    private $app;

    /**
     * @codeCoverageIgnore
     */
    public function __construct($merchantType, $config = array())
    {
        $this->app = require __DIR__ . '/../bootstrap/bootstrap.php';
    }

    public function getApp()
    {
        return $this->app;
    }
}