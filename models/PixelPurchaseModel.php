<?php

namespace Craft;

class PixelPurchaseModel extends PixelDataModel {

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function formattedData()
    {
        return $this->orderId;
    }
}