<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\DeliveryCustomerMapperTransfer;

interface DeliveryCustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\DeliveryCustomerMapperTransfer $deliveryCustomerMapperTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssDeliveryCustomerTransfer
     */
    public function map(DeliveryCustomerMapperTransfer $deliveryCustomerMapperTransfer);
}
