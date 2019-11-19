<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MerchantProfile\Persistence;

use Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfileAddressQuery;
use Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfileQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper\MerchantProfileAddressMapper;
use Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper\MerchantProfileAddressMapperInterface;
use Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper\MerchantProfileMapper;
use Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper\MerchantProfileMapperInterface;

/**
 * @method \Spryker\Zed\MerchantProfile\Persistence\MerchantProfileEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\MerchantProfile\Persistence\MerchantProfileRepositoryInterface getRepository()
 * @method \Spryker\Zed\MerchantProfile\MerchantProfileConfig getConfig()
 */
class MerchantProfilePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfileQuery
     */
    public function createMerchantProfileQuery(): SpyMerchantProfileQuery
    {
        return SpyMerchantProfileQuery::create();
    }

    /**
     * @return \Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper\MerchantProfileMapperInterface
     */
    public function createPropelMerchantProfileMapper(): MerchantProfileMapperInterface
    {
        return new MerchantProfileMapper($this->createMerchantProfileAddressMapper());
    }

    /**
     * @return \Orm\Zed\MerchantProfile\Persistence\SpyMerchantProfileAddressQuery
     */
    public function createMerchantProfileAddressQuery(): SpyMerchantProfileAddressQuery
    {
        return SpyMerchantProfileAddressQuery::create();
    }

    /**
     * @return \Spryker\Zed\MerchantProfile\Persistence\Propel\Mapper\MerchantProfileAddressMapperInterface
     */
    public function createMerchantProfileAddressMapper(): MerchantProfileAddressMapperInterface
    {
        return new MerchantProfileAddressMapper();
    }
}
