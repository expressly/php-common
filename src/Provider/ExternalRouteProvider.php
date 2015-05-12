<?php

namespace Expressly\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Expressly\Entity\Route;

class ExternalRouteProvider implements ConfigProviderInterface
{
    private $routes;

    public function __construct($hosts, $routes)
    {
        $this->routes = new ArrayCollection();

        foreach ($routes as $key => $definition) {
            $route = new Route();
            $route->setHost($hosts[$definition['host']])
                ->setURI($definition['uri'])
                ->setMethod($definition['method']);

            $this->routes->set($key, $route);
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