<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface StoreOrderResponseMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer $arvatoRssStoreOrderResponseTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function mapResponseToQuote(
        ArvatoRssStoreOrderResponseTransfer $arvatoRssStoreOrderResponseTransfer,
        QuoteTransfer $quoteTransfer
    );
}