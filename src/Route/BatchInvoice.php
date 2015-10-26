<?php

namespace Expressly\Route;

use Expressly\Entity\Route;

class BatchInvoice implements RouteInterface
{
    protected static $regex = '/^\/?expressly\/api\/batch\/invoice\/?$/';
    protected static $method = 'POST';

    public static function match($route)
    {
        if (self::$method === $_SERVER['REQUEST_METHOD'] && preg_match(self::$regex, $route)) {
            return new Route(self::getName(), self::$method, self::$regex);
        }
    }

    public static function getName()
    {
        return 'batch_invoice';
    }

    public static function isAuthenticated()
    {
        return true;
    }
}