<?php

namespace Expressly\Route;

use Buzz\Message\RequestInterface;
use Expressly\Entity\Route;

class CampaignMigration implements RouteInterface
{
    public static function match($route)
    {
        if (self::getMethod() === $_SERVER['REQUEST_METHOD'] && preg_match(self::getRegex(), $route, $matches)) {
            return new Route(self::getName(), self::getMethod(), self::getRegex(), array('uuid' => $matches[1]));
        }

        return null;
    }

    public static function getRegex()
    {
        return '/^\/?expressly\/api\/([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})\/migrate\/?$/';
    }

    public static function getMethod()
    {
        return RequestInterface::METHOD_GET;
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