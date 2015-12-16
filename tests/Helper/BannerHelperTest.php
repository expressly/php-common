<?php

use Expressly\Entity\Merchant;
use Expressly\Helper\BannerHelper;

class BannerHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyString()
    {
        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array(new Merchant(), 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('getContent')
            ->willReturn('');

        $this->assertEmpty(BannerHelper::toHtml($bannerEvent));
    }

    public function testEmptyArray()
    {
        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array(new Merchant(), 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('getContent')
            ->willReturn(array());

        $this->assertEmpty(BannerHelper::toHtml($bannerEvent));
    }

    public function testMissingMigrationLink()
    {
        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array(new Merchant(), 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('getContent')
            ->willReturn(array('bannerImageUrl' => 'http://buyexpressly.com/assets/img/expressly-logo-sm-gray.png'));

        $this->assertEmpty(BannerHelper::toHtml($bannerEvent));
    }

    public function testMissingBannerImageUrl()
    {
        $bannerEvent = $this->getMockBuilder('Expressly\Event\BannerEvent')
            ->setConstructorArgs(array(new Merchant(), 'test@email.com'))
            ->getMock();

        $bannerEvent
            ->method('getContent')
            ->willReturn(array('migrationLink' => 'http://buyexpressly.com/expressly/api/50602095-c390-4a8f-bc88-728d725b1410'));

        $this->assertEmpty(BannerHelper::toHtml($bannerEvent));
    }

    public function testSuccessful()
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
                '<div class="expressly-banner"><a href="%s"><img src="%s"/></a></div>',
                $migrationUrl,
                $imageUrl
            )
        );
    }
}