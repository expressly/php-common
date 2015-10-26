<?php

namespace Expressly\Resolver;

use Expressly\Route\RouteInterface;
use Silex\Application;

class RouteResolver implements ResolverInterface
{
    private $merchant;
    private $routes = array();

    public function __construct(Application $app, Array $routes)
    {
        $this->merchant = $app['merchant.provider']->getMerchant();

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

            header('HTTP/1.1 401 Unauthorized');

            return false;
        }

        return true;
    }
}