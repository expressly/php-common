<?php

namespace Expressly\Route;

use Expressly\Entity\Route;

abstract class AbstractRoute implements RouteInterface
{
    protected static $regex;
    protected static $method;

    public static function match($route)
    {
        if (self::$method === $_SERVER['REQUEST_METHOD'] && preg_match(self::$regex, $route)) {
            return new Route(self::getName(), self::$method, self::$regex);
        }

        return null;
    }
}