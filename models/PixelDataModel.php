<?php

namespace Craft;

abstract class PixelDataModel {

    abstract public function formattedData();

    final public function getFormattedData()
    {
        return $this->formattedData();
    }
}