<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;

interface StoreOrderRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer
     */
    public function mapQuoteToRequestTransfer(QuoteTransfer $quoteTransfer);
}
