<?php

namespace Expressly\Route;

use Expressly\Entity\Route;

class CampaignMigration implements RouteInterface
{
    protected static $regex = '/^\/?expressly\/api\/([0-9a-zA-Z\-]+)\/migrate\/?$/';
    protected static $method = 'GET';

    public static function match($route)
    {
        if (self::$method === $_SERVER['REQUEST_METHOD'] && preg_match(self::$regex, $route, $matches)) {
            return new Route(self::getName(), self::$method, self::$regex, array('uuid' => $matches[1]));
        }
    }

    public static function getName()
    {
        return 'campaign_migration';
    }

    public static function isAuthenticated()
    {
        return false;
    }
}