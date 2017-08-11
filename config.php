<?php
/**
 * FB Pixel Configuration
 *
 * Completely optional configuration settings for FB Pixel if you want specific control over things.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'fbpixel.php' and make
 * your changes there.
 */

return [
    /**
     * fbpixel will by default render on any environment. If you want to shut it off then you can override it per environment (if you have multi environment configs setup).
     */
    'noop' => false,

    /**
     * you have to provide a pixel id in the admin. We give you the option to override that here. Mainly, because we have a test pixel id that we use.
     */
    'pixelId' => '',
];
