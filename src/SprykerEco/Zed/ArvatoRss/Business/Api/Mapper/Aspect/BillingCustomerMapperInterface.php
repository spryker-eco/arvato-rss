<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\BillingCustomerMapperTransfer;

interface BillingCustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\BillingCustomerMapperTransfer $billingCustomerMapperTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer
     */
    public function map(BillingCustomerMapperTransfer $billingCustomerMapperTransfer);
}
