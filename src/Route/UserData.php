<?php

namespace Expressly\Route;

use Buzz\Message\RequestInterface;
use Expressly\Entity\Route;

class UserData implements RouteInterface
{
    public static function match($route)
    {
        if (self::getMethod() === $_SERVER['REQUEST_METHOD'] && preg_match(self::getRegex(), $route, $matches)) {
            return new Route(self::getName(), self::getMethod(), self::getRegex(), array('email' => $matches[1]));
        }

        return null;
    }

    public static function getName()
    {
        return 'user_data';
    }

    public static function getRegex()
    {
        return '/^\/?expressly\/api\/user\/([0-9a-zA-Z\-\_]+\@[0-9a-zA-Z\-\_\.]+)\/?$/';
    }

    public static function getMethod()
    {
        return RequestInterface::METHOD_GET;
    }

    public static function isAuthenticated()
    {
        return true;
    }
}