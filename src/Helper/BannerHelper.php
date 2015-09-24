<?php

namespace Expressly\Helper;

use Expressly\Event\BannerEvent;

class BannerHelper
{
    public static function toHtml(BannerEvent $event)
    {
        $content = $event->getContent();

        if (!is_array($content)) {
            return '';
        }

        if (!array_key_exists('migrationLink', $content) || !array_key_exists('bannerImageUrl', $content)) {
            return '';
        }

        return sprintf(
            '<div class="expressly-banner"><a href="%s"><img src="%s"/></a>',
            $content['migrationLink'],
            $content['bannerImageUrl']
        );
    }
}