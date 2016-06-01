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
                if (($result = $route::match(preg_replace('/.*(expressly\/.*)/i', '/${1}', $key))) && $this->authenticate($route::isAuthenticated())) {
                    return $result;
                }
            }
        }
        return null;
    }

    private function authenticate($restricted)
    {
        if ($restricted) {
            if (!empty($_SERVER['HTTP_X_XLY_TOKEN']) &&
                empty($_SERVER['PHP_AUTH_USER']) &&
                empty($_SERVER['PHP_AUTH_PW'])
            ) {
                list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode($_SERVER['HTTP_X_XLY_TOKEN']));
            }

            if (!empty($_SERVER['PHP_AUTH_USER']) &&
                !empty($_SERVER['PHP_AUTH_PW']) &&
                $this->merchant->getUuid() === $_SERVER['PHP_AUTH_USER'] &&
                $this->merchant->getPassword() === $_SERVER['PHP_AUTH_PW']
            ) {
                return true;
            }

            header('HTTP/1.1 401 Unauthorized', true, 401);

            return false;
        }

        return true;
    }
}