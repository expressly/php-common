<?php

namespace Expressly\Provider;

class JavaScriptProvider
{
    private $js;

    public function __construct()
    {
        $this->js = scandir(__DIR__ . '/../Resources/js/');
    }

    public function getJs()
    {
        return $this->js;
    }
}