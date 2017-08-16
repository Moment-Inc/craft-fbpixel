<?php

namespace Craft;

class FbPixel_AddPaymentInfoService extends BaseApplicationComponent {

    public function render()
    {
        $cart = craft()->commerce_cart->getCart();

        $contentIds = array_map(function ($i) {
            return $i->sku;
        }, $cart->lineItems);

        $eventData = [
            'value'            => $cart->totalPrice,
            'currency'         => 'USD',
            'content_ids'      => $contentIds,
            'content_category' => 'Checkout',
        ];

        return craft()->fbPixel->renderTemplate('addPaymentInfo', ['eventData' => $eventData]);
    }
}
