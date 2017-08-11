<?php
namespace Craft;

class FbPixelPlugin extends BasePlugin
{
    public function init()
    {
        craft()->fbPixel->listen();
    }

    public function getName()
    {
        return Craft::t('Facebook Pixel');
    }

    public function getDescription()
    {
        return Craft::t('Integrates Facebook Pixel with Craft Commerce');
    }

    public function getVersion()
    {
        return '0.0.1';
    }

    public function getDeveloper()
    {
        return 'Moment, Inc';
    }

    public function getDeveloperUrl()
    {
        return 'http://github.com/Moment-Inc';
    }
}
