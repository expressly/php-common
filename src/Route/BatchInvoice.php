<?php

namespace Expressly\Route;

use Buzz\Message\RequestInterface;

class BatchInvoice extends AbstractRoute
{
    public static function getName()
    {
        return 'batch_invoice';
    }

    public static function getRegex()
    {
        return '/^\/?expressly\/api\/batch\/invoice\/?$/';
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