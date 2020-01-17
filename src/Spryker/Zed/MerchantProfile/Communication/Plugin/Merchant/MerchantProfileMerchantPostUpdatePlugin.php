<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfile\Communication\Plugin\Merchant;

use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantExtension\Dependency\Plugin\MerchantPostUpdatePluginInterface;

/**
 * @method \Spryker\Zed\MerchantProfile\Business\MerchantProfileFacadeInterface getFacade()
 * @method \Spryker\Zed\MerchantProfile\MerchantProfileConfig getConfig()
 */
class MerchantProfileMerchantPostUpdatePlugin extends AbstractPlugin implements MerchantPostUpdatePluginInterface
{
    /**
     * {@inheritDoc}
     * - Saves merchant profile after the merchant is updated.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantTransfer $originalMerchantTransfer
     * @param \Generated\Shared\Transfer\MerchantTransfer $updatedMerchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function postUpdate(MerchantTransfer $originalMerchantTransfer, MerchantTransfer $updatedMerchantTransfer): MerchantResponseTransfer
    {
        $merchantProfileTransfer = $updatedMerchantTransfer->getMerchantProfile();
        $merchantProfileTransfer->setFkMerchant($updatedMerchantTransfer->getIdMerchant());
        if ($merchantProfileTransfer->getIdMerchantProfile() === null) {
            $merchantProfileTransfer = $this->getFacade()->createMerchantProfile($merchantProfileTransfer);

            return (new MerchantResponseTransfer())
                ->setIsSuccess(true)
                ->setMerchant($updatedMerchantTransfer->setMerchantProfile($merchantProfileTransfer));
        }

        $merchantProfileTransfer = $this->getFacade()->updateMerchantProfile($merchantProfileTransfer);

        return (new MerchantResponseTransfer())
            ->setIsSuccess(true)
            ->setMerchant($updatedMerchantTransfer->setMerchantProfile($merchantProfileTransfer));
    }
}