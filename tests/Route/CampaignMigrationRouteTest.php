<?php

use Expressly\Route\CampaignMigration;

class CampaignMigrationRouteTest extends AbstractRouteTest
{
    public function testName()
    {
        $this->assertEquals(CampaignMigration::getName(), 'campaign_migration');
    }

    public function testRegex()
    {
        $this->assertRegExp(CampaignMigration::getRegex(),
            '/expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222/migrate/');
        $this->assertRegExp(CampaignMigration::getRegex(),
            '/expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222/migrate');
        $this->assertRegExp(CampaignMigration::getRegex(),
            'expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222/migrate/');
        $this->assertRegExp(CampaignMigration::getRegex(),
            'expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222/migrate');
    }

    public function testMethod()
    {
        $this->assertEquals(CampaignMigration::getMethod(), 'GET');
    }

    public function testAuthorization()
    {
        $this->assertFalse(CampaignMigration::isAuthenticated());
    }

    public function testResolver()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222/migrate');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), CampaignMigration::getName());
    }
}