<?php

namespace Expressly\Route;

class Registered extends AbstractRoute
{
    protected static $regex = '/^\/?expressly\/api\/registered\/?$/';
    protected static $method = 'GET';

    public static function getName()
    {
        return 'registered';
    }

    public static function isAuthenticated()
    {
        return true;
    }
}