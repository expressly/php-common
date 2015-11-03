<?php

namespace Expressly\Route;

use Buzz\Message\RequestInterface;

class BatchCustomer extends AbstractRoute
{
    public static function getName()
    {
        return 'batch_customer';
    }

    public static function getRegex()
    {
        return '/^\/?expressly\/api\/batch\/customer\/?$/';
    }

    public static function getMethod()
    {
        return RequestInterface::METHOD_POST;
    }

    public static function isAuthenticated()
    {
        return true;
    }
}