<?php

namespace Craft;


trait HookAndFlashUtility {
    public function addHook()
    {
        craft()->templates->hook('fbPixel.renderBase', [
            $this, 'renderTemplate'
        ]);
    }

    public function getFlash()
    {
        $classname = get_called_class();
        return craft()->userSession->getFlash($classname::FLASH_NAME);
    }

    public function doesFlashExist()
    {
        $classname = get_called_class();
        return craft()->userSession->hasFlash($classname::FLASH_NAME);
    }

    public function addFlash(PixelDataModel $model)
    {
        $classname = get_called_class();
        craft()->userSession->setFlash($classname::FLASH_NAME, $model->getFormattedData());
    }
}