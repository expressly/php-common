<?php

namespace Expressly\Route;

use Expressly\Entity\Route;

class Ping implements RouteInterface
{
    protected static $regex = '/^\/?expressly\/api\/ping\/?$/';
    protected static $method = 'GET';

    public static function match($route)
    {
        if (self::$method === $_SERVER['REQUEST_METHOD'] && preg_match(self::$regex, $route)) {
            return new Route(self::getName(), self::$method, self::$regex);
        }

        return null;
    }

    public static function getName()
    {
        return 'ping';
    }

    public static function isAuthenticated()
    {
        return false;
    }
}