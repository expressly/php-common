<?php

namespace Expressly\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use Expressly\Entity\ExternalRoute;
use Pimple\Container;

class ExternalRouteProvider implements ConfigProviderInterface
{
    private $routes;

    public function __construct(Container $container, $hosts, $routes)
    {
        $this->routes = new ArrayCollection();

        foreach ($routes as $key => $definition) {
            $route = new ExternalRoute();
            $route->setHost($hosts[$definition['host']])
                ->setURI($definition['uri'])
                ->setMethod($definition['method']);

            if (!empty($definition['validation'])) {
                $validation = array();

                foreach ($definition['validation'] as $parameter => $validatorKey) {
                    $validation[$parameter] = $container["{$validatorKey}.validator"];
                }

                $route->setRules($validation);
            }

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