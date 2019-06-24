<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface ArvatoRssFacadeInterface
{
    /**
     * Specification:
     *  - Performs RiskCheck API call.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTrasnfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTrasnfer);

    /**
     * Specification:
     *  - Performs StoreOrder API call.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function storeOrder(OrderTransfer $orderTransfer);

    /**
     * Specification:
     *  - Updates API log row with order reference.
     *
     * @api
     *
     * @param string $communicationToken
     * @param string $orderReference
     *
     * @return void
     */
    public function updateApiLog(string $communicationToken, string $orderReference): void;
}
