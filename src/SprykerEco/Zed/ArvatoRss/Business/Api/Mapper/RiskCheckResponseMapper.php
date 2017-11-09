<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

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
        $quoteTransfer->setArvatoRssRiskCheckResponse($arvatoRssRiskCheckResponseTransfer);

        return $quoteTransfer;
    }
}
