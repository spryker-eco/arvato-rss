<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
