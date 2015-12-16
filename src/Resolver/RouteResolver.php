<?php

namespace Expressly\Resolver;

use Expressly\Route\RouteInterface;
use Pimple\Container;

class RouteResolver implements ResolverInterface
{
    private $merchant;
    private $routes = array();

    public function __construct(Container $container, Array $routes)
    {
        $this->merchant = $container['merchant.provider']->getMerchant();

        foreach ($routes as $class) {
            $this->routes[] = new $class();
        }
    }

    public function process($key)
    {
        foreach ($this->routes as $route) {
            if ($route instanceof RouteInterface) {
                if (($result = $route::match($key)) && $this->authenticate($route::isAuthenticated())) {
                    return $result;
                }
            }
        }

        return null;
    }

    private function authenticate($restricted)
    {
        if ($restricted) {
            if (!empty($_SERVER['PHP_AUTH_USER']) &&
                !empty($_SERVER['PHP_AUTH_PW']) &&
                $this->merchant->getUuid() === $_SERVER['PHP_AUTH_USER'] &&
                $this->merchant->getPassword() === $_SERVER['PHP_AUTH_PW']
            ) {
                return true;
            }

            http_response_code(401);

            return false;
        }

        return true;
    }
}