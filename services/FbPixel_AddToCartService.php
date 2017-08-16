<?php

namespace Craft;

class FbPixel_AddToCartService extends BaseApplicationComponent implements Flashable {

    /**
     * Traits
     */
    use HookAndFlashUtility;

    const FLASH_NAME = '_fbPixelVariantIds';

    private $variantIds;

    public function listen()
    {
        craft()->on('multiAdd_cart.MultiAddToCart', [
            $this, 'onMultiAddToCartHandler',
        ]);

        craft()->on('commerce_cart.onAddToCart', [
            $this, 'onAddToCartHandler',
        ]);

        craft()->fbPixel_addToCart->checkFlash();
    }

    /**
     * @param $event
     */
    public function onAddToCartHandler($event)
    {
        $lineItem = $event->params['lineItem'];
        $this->setFlash([$lineItem]);
    }

    /**
     * @param $event
     */
    public function onMultiAddToCartHandler($event)
    {
        $lineItems = $event->params['lineItems'];
        $this->setFlash($lineItems);
    }

    public function checkFlash()
    {
        if ($this->doesFlashExist()) {
            $this->variantIds = craft()->userSession->getFlash(self::FLASH_NAME, null, true);
            $this->addHook();
        }
    }

    /**
     * @param $lineItems
     */
    public function setFlash($lineItems)
    {
        $variantIds = $this->getFlash();

        if (empty($variantIds)) {
            $variantIds = [];
        }

        $variantIds = array_merge(
            $variantIds,
            $this->getVariantIds($lineItems)
        );

        $addToCartDataModel = new PixelAddToCartModel($variantIds);

        $this->addFlash($addToCartDataModel);
    }

    /**
     * @param $lineItems
     * @return array
     */
    private function getVariantIds($lineItems)
    {
        return array_map(function ($lineItem) {
            $purchasable = $lineItem->purchasable;
            return (!empty($purchasable->defaultVariant)) ? $purchasable->defaultVariant->id : $purchasable->id;
        }, $lineItems);
    }

    public function renderTemplate()
    {
        $template = '';

        foreach ($this->variantIds as $variantId) {
            $variant = craft()->commerce_variants->getVariantById($variantId);

            $eventData = [
                'value'        => $variant->salePrice,
                'currency'     => 'USD',
                'content_name' => 'Add To Cart',
                'content_ids'  => $variant->sku,
                'content_type' => 'product',
            ];

            $template .= craft()->fbPixel->renderEvent('AddToCart', $eventData);
        }

        return $template;
    }
}
