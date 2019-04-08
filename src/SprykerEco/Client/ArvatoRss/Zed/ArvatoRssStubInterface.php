<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\ArvatoRss\Zed;

use Generated\Shared\Transfer\QuoteTransfer;

interface ArvatoRssStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTransfer);
}
