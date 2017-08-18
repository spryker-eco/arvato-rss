<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\ArvatoRss\Zed;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class ArvatoRssStub extends ZedRequestStub implements ArvatoRssStubInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTransfer)
    {
        return $this->zedStub->call(
            '/arvato-rss/gateway/perform-risk-check',
            $quoteTransfer
        );
    }

}
