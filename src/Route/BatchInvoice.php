<?php

namespace Expressly\Route;

use Expressly\Entity\Route;

class BatchInvoice extends AbstractRoute
{
    protected static $regex = '/^\/?expressly\/api\/batch\/invoice\/?$/';
    protected static $method = 'POST';

    public static function getName()
    {
        return 'batch_invoice';
    }

    public static function isAuthenticated()
    {
        return true;
    }
}