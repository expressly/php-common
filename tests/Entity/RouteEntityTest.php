<?php

use Expressly\Entity\Route;

class RouteEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testGettersReturn()
    {
        $route = new Route('test_route', 'GET', '/^\w+$/', array('data' => 5));

        $this->assertEquals('test_route', $route->getName());
        $this->assertEquals('GET', $route->getMethod());
        $this->assertEquals('/^\w+$/', $route->getRoute());
        $this->assertEquals(array('data' => 5), $route->getData());
    }
}