<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OrderMapperTransfer;
use Generated\Shared\Transfer\TotalsTransfer;

interface OrderMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderMapperTransfer $orderMapperTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderTransfer
     */
    public function map(OrderMapperTransfer $orderMapperTransfer);
}
