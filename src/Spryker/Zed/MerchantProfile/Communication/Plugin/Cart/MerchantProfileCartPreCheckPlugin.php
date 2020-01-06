<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfile\Communication\Plugin\Cart;

use ArrayObject;
use Generated\Shared\Transfer\CartChangeTransfer;
use Generated\Shared\Transfer\CartPreCheckResponseTransfer;
use Generated\Shared\Transfer\MerchantProfileCriteriaFilterTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Spryker\Zed\CartExtension\Dependency\Plugin\CartPreCheckPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Spryker\Zed\MerchantProfile\Business\MerchantProfileFacadeInterface getFacade()
 * @method \Spryker\Zed\MerchantProfile\MerchantProfileConfig getConfig()
 */
class MerchantProfileCartPreCheckPlugin extends AbstractPlugin implements CartPreCheckPluginInterface
{
    protected const MESSAGE_TYPE_ERROR = 'error';

    protected const GLOSSARY_KEY_INACTIVE_MERCHANT_PROFILE = 'merchant_profile.message.inactive';
    protected const GLOSSARY_KEY_REMOVED_MERCHANT_PROFILE = 'merchant_profile.message.removed';

    protected const GLOSSARY_PARAM_SKU = '%sku%';
    protected const GLOSSARY_PARAM_MERCHANT_NAME = '%merchant_name%';

    /**
     * {@inheritDoc}
     * - Checks if cart change transfer has items with inactive merchants.
     * - Returns unsuccessful response with error messages, if cart change transfer has items with inactive merchants.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CartChangeTransfer $cartChangeTransfer
     *
     * @return \Generated\Shared\Transfer\CartPreCheckResponseTransfer
     */
    public function check(CartChangeTransfer $cartChangeTransfer): CartPreCheckResponseTransfer
    {
        $messageTransfers = [];

        foreach ($cartChangeTransfer->getItems() as $itemTransfer) {
            if (!$itemTransfer->getMerchantReference()) {
                continue;
            }

            $merchantProfileTransfer = $this->getFacade()->findOne(
                (new MerchantProfileCriteriaFilterTransfer())
                    ->setMerchantReference($itemTransfer->getMerchantReference())
            );

            if (!$merchantProfileTransfer) {
                $messageTransfers[] = (new MessageTransfer())
                    ->setType(static::MESSAGE_TYPE_ERROR)
                    ->setValue(static::GLOSSARY_KEY_REMOVED_MERCHANT_PROFILE)
                    ->setParameters([static::GLOSSARY_PARAM_SKU => $itemTransfer->getSku()]);
            }

            if (!$merchantProfileTransfer->getIsActive()) {
                $messageTransfers[] = (new MessageTransfer())
                    ->setType(static::MESSAGE_TYPE_ERROR)
                    ->setValue(static::GLOSSARY_KEY_INACTIVE_MERCHANT_PROFILE)
                    ->setParameters([
                        static::GLOSSARY_PARAM_SKU => $itemTransfer->getSku(),
                        static::GLOSSARY_PARAM_MERCHANT_NAME => $merchantProfileTransfer->getMerchantName(),
                    ]);
            }
        }

        return (new CartPreCheckResponseTransfer())
            ->setMessages(new ArrayObject($messageTransfers))
            ->setIsSuccess(!$messageTransfers);
    }
}
