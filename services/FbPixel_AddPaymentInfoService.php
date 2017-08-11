<?php

namespace Craft;

class FbPixel_AddPaymentInfoService extends BaseApplicationComponent
{
    public function render()
    {
        $cart = craft()->commerce_cart->getCart();
        $eventData = [
            'value' => $cart->totalPrice,
            'currency' => 'USD',
            'content_ids' => array_map(function($i) { return $i->sku; }, $cart->lineItems),
            'content_category' => 'Checkout',
        ];

        return craft()->fbPixel->renderTemplate('addPaymentInfo', ['eventData' => $eventData]);
    }
}
