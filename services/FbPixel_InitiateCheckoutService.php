<?php

namespace Craft;

class FbPixel_InitiateCheckoutService extends BaseApplicationComponent {

    public function listen()
    {
        craft()->templates->hook('fbPixel.renderInitiateCheckout', [
            craft()->fbPixel_initiateCheckout, 'render',
        ]);
    }

    public function render()
    {
        $cart = craft()->commerce_cart->getCart();
        $addPaymentInfoRaw = craft()->fbPixel_addPaymentInfo->render();
        $item = [
            'content_name' => 'Checkout',
            'content_ids'  => array_map(function ($i) {
                return $i->sku;
            }, $cart->lineItems),
            'content_type' => 'product',
            'num_items'    => $cart->getTotalQty(),
            'value'        => $cart->totalPrice,
            'currency'     => 'USD',
        ];

        return $addPaymentInfoRaw . craft()->fbPixel->renderEvent('InitiateCheckout', $item);
    }
}
