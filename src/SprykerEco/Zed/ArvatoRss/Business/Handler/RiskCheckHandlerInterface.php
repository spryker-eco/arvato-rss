<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Handler;

use Generated\Shared\Transfer\QuoteTransfer;

interface RiskCheckHandlerInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return QuoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTransfer);

}