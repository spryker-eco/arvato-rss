<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

interface RiskCheckResponseMapperInterface
{

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer $arvatoRssRiskCheckResponseTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function mapResponseToQuote(
        ArvatoRssRiskCheckResponseTransfer $arvatoRssRiskCheckResponseTransfer,
        QuoteTransfer $quoteTransfer
    );

}