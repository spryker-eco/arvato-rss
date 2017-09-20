<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\ArvatoRss;

use Generated\Shared\Transfer\QuoteTransfer;

interface ArvatoRssClientInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTransfer);

}
