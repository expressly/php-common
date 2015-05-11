<?php

namespace Expressly\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Expressly\Entity\Route;

class ExternalRouteProvider implements ConfigProviderInterface
{
    private $routes;

    public function __construct($host, $routes)
    {
        $this->routes = new ArrayCollection();

        foreach ($routes as $key => $route) {
            $this->routes->set($key, new Route($host, $route['uri'], $route['method']));
        }
    }

    public function __get($key)
    {
        if ($this->routes->containsKey($key)) {
            return $this->routes->get($key);
        }

        return null;
    }
}