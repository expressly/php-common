<?php

namespace Expressly\Route;

use Expressly\Entity\Route;

abstract class AbstractRoute implements RouteInterface
{
    public static function match($route)
    {
        if (static::getMethod() === $_SERVER['REQUEST_METHOD'] && preg_match(static::getRegex(), $route)) {
            return new Route(static::getName(), static::getMethod(), static::getRegex());
        }

        return null;
    }
}