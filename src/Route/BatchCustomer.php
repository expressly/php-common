<?php

namespace Expressly\Route;

class BatchCustomer extends AbstractRoute
{
    protected static $regex = '/^\/?expressly\/api\/batch\/customer\/?$/';
    protected static $method = 'POST';

    public static function getName()
    {
        return 'batch_customer';
    }

    public static function isAuthenticated()
    {
        return true;
    }
}