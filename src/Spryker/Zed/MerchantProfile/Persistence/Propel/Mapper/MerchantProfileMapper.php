<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\MerchantProfileAddressCollectionTransfer;
use Generated\Shared\Transfer\MerchantProfileTransfer;
use Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfile;

class MerchantProfileMapper implements MerchantProfileMapperInterface
{
    /**
     * @var \Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper\MerchantProfileAddressMapperInterface
     */
    protected $merchantProfileAddressMapper;

    /**
     * @param \Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper\MerchantProfileAddressMapperInterface $merchantProfileAddressMapper
     */
    public function __construct(MerchantProfileAddressMapperInterface $merchantProfileAddressMapper)
    {
        $this->merchantProfileAddressMapper = $merchantProfileAddressMapper;
    }

    /**
     * @param \Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfile $merchantProfileEntity
     * @param \Generated\Shared\Transfer\MerchantProfileTransfer $merchantProfileTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantProfileTransfer
     */
    public function mapMerchantProfileEntityToMerchantProfileTransfer(
        SpyMerchantProfile $merchantProfileEntity,
        MerchantProfileTransfer $merchantProfileTransfer
    ): MerchantProfileTransfer {
        $merchantProfileTransfer->fromArray(
            $merchantProfileEntity->toArray(),
            true
        );

        $merchantProfileTransfer->setMerchantName($merchantProfileEntity->getSpyMerchant()->getName());
        $merchantProfileTransfer->setMerchantReference($merchantProfileEntity->getSpyMerchant()->getMerchantReference());

        $merchantProfileAddressCollectionTransfer = $this->merchantProfileAddressMapper->mapMerchantProfileAddressEntityCollectionToMerchantProfileAddressCollectionTransfer(
            $merchantProfileEntity->getSpyMerchantProfileAddresses(),
            new MerchantProfileAddressCollectionTransfer()
        );

        $merchantProfileTransfer->setAddressCollection($merchantProfileAddressCollectionTransfer);

        return $merchantProfileTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantProfileTransfer $merchantProfileTransfer
     * @param \Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfile $spyMerchantProfile
     *
     * @return \Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfile
     */
    public function mapMerchantProfileTransferToMerchantProfileEntity(
        MerchantProfileTransfer $merchantProfileTransfer,
        SpyMerchantProfile $spyMerchantProfile
    ): SpyMerchantProfile {
        $spyMerchantProfile->fromArray(
            $merchantProfileTransfer->modifiedToArray(false)
        );

        return $spyMerchantProfile;
    }
}
