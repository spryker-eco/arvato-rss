<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssQuoteDataTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class RiskCheckResponseMapper implements RiskCheckResponseMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer $arvatoRssRiskCheckResponseTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function mapResponseToQuote(
        ArvatoRssRiskCheckResponseTransfer $arvatoRssRiskCheckResponseTransfer,
        QuoteTransfer $quoteTransfer
    ) {
        if (!$quoteTransfer->getArvatoRssQuoteData()) {
            $quoteTransfer->setArvatoRssQuoteData(new ArvatoRssQuoteDataTransfer());
        }
        $quoteTransfer->getArvatoRssQuoteData()
            ->setArvatoRssRiskCheckResponse($arvatoRssRiskCheckResponseTransfer);

        return $quoteTransfer;
    }
}
