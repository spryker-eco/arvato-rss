<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssQuoteDataTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class StoreOrderResponseMapper implements StoreOrderResponseMapperInterface
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
    ) {
        if (!$quoteTransfer->getArvatoRssQuoteData()) {
            $quoteTransfer->setArvatoRssQuoteData(new ArvatoRssQuoteDataTransfer());
        }
        $quoteTransfer->getArvatoRssQuoteData()
            ->setArvatoRssStoreOrderResponse($arvatoRssStoreOrderResponseTransfer);

        return $quoteTransfer;
    }
}
