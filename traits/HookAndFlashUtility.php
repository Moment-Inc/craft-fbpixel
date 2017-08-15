<?php

namespace Craft;


trait HookAndFlashUtility {
    public function addHook()
    {
        craft()->templates->hook('fbPixel.renderBase', [
            $this, 'renderTemplate'
        ]);
    }
}