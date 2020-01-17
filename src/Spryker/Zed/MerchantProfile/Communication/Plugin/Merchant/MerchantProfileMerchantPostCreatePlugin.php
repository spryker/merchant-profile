<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfile\Communication\Plugin\Merchant;

use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantExtension\Dependency\Plugin\MerchantPostCreatePluginInterface;

/**
 * @method \Spryker\Zed\MerchantProfile\Business\MerchantProfileFacadeInterface getFacade()
 * @method \Spryker\Zed\MerchantProfile\MerchantProfileConfig getConfig()
 */
class MerchantProfileMerchantPostCreatePlugin extends AbstractPlugin implements MerchantPostCreatePluginInterface
{
    /**
     * {@inheritDoc}
     * - Saves merchant profile after the merchant is created.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function postCreate(MerchantTransfer $merchantTransfer): MerchantResponseTransfer
    {
        $merchantProfileTransfer = $merchantTransfer->getMerchantProfile()->setFkMerchant($merchantTransfer->getIdMerchant());
        $merchantProfileTransfer = $this->getFacade()->createMerchantProfile($merchantProfileTransfer);
        $merchantTransfer->setMerchantProfile($merchantProfileTransfer);

        return (new MerchantResponseTransfer())
            ->setIsSuccess(true)
            ->setMerchant($merchantTransfer);
    }
}
