<?php

namespace Expressly\Test\Helper;

use Expressly\Entity\Merchant;
use Expressly\Helper\BannerHelper;

class BannerHelperTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        require_once __DIR__ . '/../../../vendor/autoload.php';
    }

    public function testFailedEvent()
    {
        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array(new Merchant(), 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('getContent')
            ->willReturn(array());

        $this->assertEmpty(BannerHelper::toHtml($bannerEvent));
    }

    public function testMissingMigrationLinkEven()
    {
        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array(new Merchant(), 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('getContent')
            ->willReturn(array('bannerImageUrl' => 'http://buyexpressly.com/assets/img/expressly-logo-sm-gray.png'));

        $this->assertEmpty(BannerHelper::toHtml($bannerEvent));
    }

    public function testMissingBannerImageUrlEvent()
    {
        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array(new Merchant(), 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('getContent')
            ->willReturn(array('migrationLink' => 'http://buyexpressly.com/expressly/api/50602095-c390-4a8f-bc88-728d725b1410'));

        $this->assertEmpty(BannerHelper::toHtml($bannerEvent));
    }

    public function testSuccessfulEvent()
    {
        $imageUrl = 'http://buyexpressly.com/assets/img/expressly-logo-sm-gray.png';
        $migrationUrl = 'http://buyexpressly.com/expressly/api/50602095-c390-4a8f-bc88-728d725b1410';

        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array(new Merchant(), 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('getContent')
            ->willReturn(array(
                'bannerImageUrl' => $imageUrl,
                'migrationLink' => $migrationUrl
            ));

        $this->assertEquals(
            BannerHelper::toHtml($bannerEvent),
            sprintf(
                '<div class="expressly-banner"><a href="%s"><img src="%s"/></a>',
                $migrationUrl,
                $imageUrl
            )
        );
    }
}