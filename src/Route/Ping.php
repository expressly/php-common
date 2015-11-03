<?php

namespace Expressly\Route;

class Ping extends AbstractRoute
{
    protected static $regex = '/^\/?expressly\/api\/ping\/?$/';
    protected static $method = 'GET';

    public static function getName()
    {
        return 'ping';
    }

    public static function isAuthenticated()
    {
        return false;
    }
}