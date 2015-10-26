<?php

namespace Expressly\Route;

interface RouteInterface
{
    public static function getName();

    public static function match($route);

    public static function isAuthenticated();
}