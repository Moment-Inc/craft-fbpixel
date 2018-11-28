<?php

namespace Craft;

class FbPixel_PurchaseService extends BaseApplicationComponent
{
    const FLASH_NAME = '_fbPixelOrderId';

    private $order;

    public function listen()
    {
        craft()->on('commerce_orders.onOrderComplete', [
            craft()->fbPixel_purchase, 'addFlash'
        ]);

        craft()->fbPixel_purchase->checkFlash();
    }

    public function checkFlash()
    {
        if (craft()->userSession->hasFlash(self::FLASH_NAME, null, true)) {
            $orderId = craft()->userSession->getFlash(self::FLASH_NAME, null, true);
        } else {
            $orderId = craft()->getRequest()->getParam('order');
        }
        if ($orderId && craft()->httpSession->get($orderId) !== true) {
            craft()->httpSession->set($orderId, true);
            $order = craft()->commerce_orders->getOrderById($orderId);
            $this->order = $order;
            $this->addHook();
        }
    }

    public function addHook()
    {
        craft()->templates->hook('fbPixel.renderBase', [
            $this, 'renderTemplate'
        ]);
    }

    public function addFlash($event)
    {
        craft()->userSession->setFlash(self::FLASH_NAME, $event->params['order']->id);
    }

    public function renderTemplate()
    {
        $eventData = [
            'content_name' => 'Purchase',
            'content_ids' => array_map(function($i) { return $i->sku; }, $this->order->lineItems),
            'content_type' => 'product',
            'num_items' => $this->order->getTotalQty(),
            'value' => $this->order->totalPrice,
            'currency' => 'USD'
        ];

        return craft()->fbPixel->renderEvent('Purchase', $eventData);
    }
}
