<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfile\Business\MerchantProfile;

use Generated\Shared\Transfer\MerchantProfileCollectionTransfer;
use Generated\Shared\Transfer\MerchantProfileCriteriaFilterTransfer;
use Generated\Shared\Transfer\MerchantProfileTransfer;

interface MerchantProfileReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantProfileCriteriaFilterTransfer $merchantProfileCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantProfileTransfer|null
     */
    public function findOne(MerchantProfileCriteriaFilterTransfer $merchantProfileCriteriaFilterTransfer): ?MerchantProfileTransfer;

    /**
     * @param \Generated\Shared\Transfer\MerchantProfileCriteriaFilterTransfer $merchantProfileCriteriaFilterTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantProfileCollectionTransfer
     */
    public function find(MerchantProfileCriteriaFilterTransfer $merchantProfileCriteriaFilterTransfer): MerchantProfileCollectionTransfer;
}
