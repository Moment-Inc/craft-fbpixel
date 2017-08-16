<?php

namespace Craft;

class PixelAddToCartModel extends PixelDataModel {

    protected $variantIds;

    public function __construct(array $variantIds)
    {
        $this->variantIds = $variantIds;
    }

    public function formattedData()
    {
        return $this->variantIds;
    }
}