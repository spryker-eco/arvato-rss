<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
