<?php

use Expressly\Route\CampaignPopup;

class CampaignPopupRouteTest extends AbstractRouteTest
{
    public function testName()
    {
        $this->assertEquals(CampaignPopup::getName(), 'campaign_popup');
    }

    public function testRegex()
    {
        $this->assertRegExp(CampaignPopup::getRegex(), '/expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222/');
        $this->assertRegExp(CampaignPopup::getRegex(), '/expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222');
        $this->assertRegExp(CampaignPopup::getRegex(), 'expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222/');
        $this->assertRegExp(CampaignPopup::getRegex(), 'expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222');
    }

    public function testMethod()
    {
        $this->assertEquals(CampaignPopup::getMethod(), 'GET');
    }

    public function testAuthorization()
    {
        $this->assertFalse(CampaignPopup::isAuthenticated());
    }

    public function testResolver()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $route = $this->routeResolver->process('/expressly/api/a2ea0a7e-eabd-4caf-a598-6b80887fc222');

        $this->assertInstanceOf('Expressly\Entity\Route', $route);
        $this->assertEquals($route->getName(), CampaignPopup::getName());
    }
}