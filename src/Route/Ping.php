<?php

namespace Expressly\Route;

use Buzz\Message\RequestInterface;

class Ping extends AbstractRoute
{
    public static function getName()
    {
        return 'ping';
    }

    public static function getRegex()
    {
        return '/^\/?expressly\/api\/ping\/?$/';
    }

    public static function getMethod()
    {
        return RequestInterface::METHOD_GET;
    }

    public static function isAuthenticated()
    {
        return false;
    }
}