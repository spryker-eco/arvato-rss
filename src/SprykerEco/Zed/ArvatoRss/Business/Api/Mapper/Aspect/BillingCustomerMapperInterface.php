<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
