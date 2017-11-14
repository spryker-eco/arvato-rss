<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\TotalsTransfer;

interface OrderMapperInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\TotalsTransfer $totalsTransfer
     * @param array $items
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderTransfer
     */
    public function map(TotalsTransfer $totalsTransfer, array $items, $orderReference);
}
