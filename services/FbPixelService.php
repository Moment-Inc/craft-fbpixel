<?php

namespace Craft;

class FbPixelService extends BaseApplicationComponent
{
    /*
     * This is called in MomentPlugin::init(). It's mainly responsible for
     * what happens on a page load.
     *
     */
    public function listen()
    {
        if (getenv('FB_PIXEL_NOOP')) {
            return;
        }

        craft()->templates->hook('fbPixel.renderBase', [
            $this, 'renderBase'
        ]);

        craft()->fbPixel_viewContent->listen();
        craft()->fbPixel_initiateCheckout->listen();
        craft()->fbPixel_purchase->listen();
        craft()->fbPixel_addToCart->listen();
    }

    /*
     * This render the moment/templates/fbpixel/base.twig which contains the fb pixel code
     *
     */
    public function renderBase()
    {
        return $this->renderTemplate('base', [
            'fbPixelId' => getenv('FB_PIXEL_ID')
        ]);
    }

    public function renderEvent($eventName, $eventData)
    {
        return $this->renderTemplate('event', [
            'eventName' => $eventName,
            'eventData' => $eventData
        ]);
    }

    public function renderTemplate($template, $templateData = [])
    {
        # this is required because we're not using CP routes for this service
        $oldPath = craft()->path->getTemplatesPath();
        $templatePath = craft()->path->getPluginsPath() . 'fbpixel/templates/';
        craft()->path->setTemplatesPath($templatePath);
        $template = craft()->templates->render($template, $templateData);
        craft()->path->setTemplatesPath($oldPath);

        return $template;
    }
}
