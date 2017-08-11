<?php

namespace Craft;

class FbPixel_ViewContentService extends BaseApplicationComponent
{
    public function listen()
    {
        craft()->templates->hook('fbPixel.renderBase', [
            $this, 'render'
        ]);
    }

    public function render(&$context)
    {
        if (!empty($context['fbPixelItem'])) {
            return craft()->fbPixel->renderEvent('ViewContent', $context['fbPixelItem']);
        }
    }
}
