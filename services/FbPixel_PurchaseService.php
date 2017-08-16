<?php

namespace Craft;

class FbPixel_PurchaseService extends BaseApplicationComponent implements Flashable {

    /**
     * Traits
     */
    use HookAndFlashUtility;

    const FLASH_NAME = '_fbPixelOrderId';

    private $order;

    public function listen()
    {
        craft()->on('commerce_orders.onOrderComplete', [
            craft()->fbPixel_purchase, 'setFlash',
        ]);

        craft()->fbPixel_purchase->checkFlash();
    }

    public function checkFlash()
    {
        if ($this->doesFlashExist()) {
            $orderId = craft()->userSession->getFlash(self::FLASH_NAME, null, true);
            $order = craft()->commerce_orders->getOrderById($orderId);
            $this->order = $order;
            $this->addHook();
        }
    }

    /**
     * @param $event
     */
    public function setFlash($event)
    {
        $purchaseDataModel = new PixelPurchaseModel($event->params['order']->id);
        $this->addFlash($purchaseDataModel);
    }

    public function renderTemplate()
    {
        $eventData = [
            'content_name' => 'Purchase',
            'content_ids'  => array_map(function ($i) {
                return $i->sku;
            }, $this->order->lineItems),
            'content_type' => 'product',
            'num_items'    => $this->order->getTotalQty(),
            'value'        => $this->order->totalPrice,
            'currency'     => 'USD',
        ];

        return craft()->fbPixel->renderEvent('Purchase', $eventData);
    }
}
