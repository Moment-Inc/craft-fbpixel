<?php

namespace Craft;

class FbPixelService extends BaseApplicationComponent
{
    /*
     * Include this into an init function within your project. It's mainly responsible for
     * what happens on a page load.
     *
     */
    public function listen()
    {
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
            'fbPixelId' => craft()->plugins->getPlugin('fbpixel')->getPixelId(),
        ]);
    }

    /**
     * @param $eventName
     * @param $eventData
     * @return mixed
     */
    public function renderEvent($eventName, $eventData)
    {
        return $this->renderTemplate('event', [
            'eventName' => $eventName,
            'eventData' => $eventData
        ]);
    }

    /**
     * @param $template
     * @param array $templateData
     * @return mixed
     */
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
