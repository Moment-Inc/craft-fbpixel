<?php

namespace Craft;

class FbPixel_ViewContentService extends BaseApplicationComponent
{
    public function listen()
    {
        craft()->templates->hook('fbPixel.renderViewContent', [
            $this, 'render'
        ]);
    }

    public function render(&$context)
    {
        return craft()->fbPixel->renderEvent('ViewContent', $context['fbPixelItem']);
    }
}
