<?php

namespace Expressly\Route;

use Buzz\Message\RequestInterface;

class Registered extends AbstractRoute
{
    public static function getName()
    {
        return 'registered';
    }

    public static function getRegex()
    {
        return '/^\/?expressly\/api\/registered\/?$/';
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