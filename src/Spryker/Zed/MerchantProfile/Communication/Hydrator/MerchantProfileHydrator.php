<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfile\Communication\Hydrator;

use Generated\Shared\Transfer\MerchantProfileCriteriaFilterTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Zed\MerchantProfile\Persistence\MerchantProfileRepositoryInterface;

class MerchantProfileHydrator implements MerchantProfileHydratorInterface
{
    /**
     * @var \Spryker\Zed\MerchantProfile\Persistence\MerchantProfileRepositoryInterface
     */
    protected $merchantProfileRepository;

    /**
     * @param \Spryker\Zed\MerchantProfile\Persistence\MerchantProfileRepositoryInterface $merchantProfileRepository
     */
    public function __construct(
        MerchantProfileRepositoryInterface $merchantProfileRepository
    ) {
        $this->merchantProfileRepository = $merchantProfileRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantTransfer
     */
    public function hydrate(MerchantTransfer $merchantTransfer): MerchantTransfer
    {
        $merchantProfileCriteriaFilterTransfer = $this->createMerchantProfileCriteriaFilterTransfer($merchantTransfer);
        $merchantProfileTransfer = $this->merchantProfileRepository->findOne($merchantProfileCriteriaFilterTransfer);

        if ($merchantProfileTransfer !== null) {
            $merchantTransfer->setMerchantProfile($merchantProfileTransfer);
        }

        return $merchantTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantProfileCriteriaFilterTransfer
     */
    protected function createMerchantProfileCriteriaFilterTransfer(MerchantTransfer $merchantTransfer): MerchantProfileCriteriaFilterTransfer
    {
        $merchantProfileCriteriaFilterTransfer = new MerchantProfileCriteriaFilterTransfer();
        $merchantProfileCriteriaFilterTransfer->setIdMerchant($merchantTransfer->getIdMerchant());

        return $merchantProfileCriteriaFilterTransfer;
    }
}