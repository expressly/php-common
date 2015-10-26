<?php

namespace Expressly\Route;

use Expressly\Entity\Route;

class UserData implements RouteInterface
{
    protected static $regex = '/^\/?expressly\/api\/user\/([0-9a-zA-Z\-\_]+\@[0-9a-zA-Z\-\_\.]+)\/?$/';
    protected static $method = 'GET';

    public static function match($route)
    {
        if (self::$method === $_SERVER['REQUEST_METHOD'] && preg_match(self::$regex, $route, $matches)) {
            return new Route(self::getName(), self::$method, self::$regex, array('email' => $matches[1]));
        }

        return null;
    }

    public static function getName()
    {
        return 'user_data';
    }

    public static function isAuthenticated()
    {
        return true;
    }
}