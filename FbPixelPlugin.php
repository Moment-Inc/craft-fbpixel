<?php
namespace Craft;

class FbPixelPlugin extends BasePlugin
{
    public function init()
    {
        if (
            craft()->config->get('noop', 'fbpixel') ||
            empty(craft()->plugins->getPlugin('commerce')) ||
            empty($this->getPixelId())
        ) {
            return;
        }

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

    public function getDocumentationUrl()
    {
        return 'https://github.com/moment-inc/craft-fbpixel/wiki';
    }

    public function getVersion()
    {
        return '0.0.5';
    }

    public function getDeveloper()
    {
        return 'Moment, Inc';
    }

    public function getDeveloperUrl()
    {
        return 'http://github.com/Moment-Inc';
    }

    public function getCpAlerts($path, $fetch)
    {
        if (empty($this->getPixelId())) {
            return ["Enter your pixel id <a href='{$this->getSettingsUrl()}'>here</a> for fbpixel to work."];
        }

        if (empty(craft()->plugins->getPlugin('commerce'))) {
            return ['Craft Commerce is required for fbpixel to work.'];
        }
    }

    public function getSettingsHtml()
    {
        return craft()->templates->render('fbpixel/settings', [
            'settings' => $this->getSettings()
        ]);
    }

    public function getPixelId()
    {
        if (!empty(craft()->config->get('pixelId', 'fbpixel'))) {
            return craft()->config->get('pixelId', 'fbpixel');
        }

        return $this->getSettings()->pixelId;
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/moment-inc/craft-fbpixel/master/releases.json';
    }

    public function getSchemaVersion()
    {
        return '0.0.0';
    }

    protected function defineSettings()
    {
        return [
            'pixelId' => array(AttributeType::String),
        ];
    }
}
