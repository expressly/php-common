<?php

namespace Expressly\Entity;

class Route
{
    protected $name;
    protected $method;
    protected $route;
    protected $data;

    public function __construct($name, $method, $route, $data = array())
    {
        $this->name = $name;
        $this->method = $method;
        $this->route = $route;
        $this->data = $data;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function getData()
    {
        return $this->data;
    }
}