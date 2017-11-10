<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssQuoteDataTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderResponseMapper;
use SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect\AbstractMapperTest;

class RiskCheckResponseMapperTest extends AbstractMapperTest
{
    /**
     * @return void
     */
    public function testMapResponseToQuote()
    {
        $mapper = new StoreOrderResponseMapper();
        $quoteTransfer = $this->createQuoteTransfer();
        $result = $mapper->mapResponseToQuote(new ArvatoRssStoreOrderResponseTransfer(), $quoteTransfer);
        $this->testResult($result);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $result
     *
     * @return void
     */
    protected function testResult($result)
    {
        $this->assertInstanceOf(QuoteTransfer::class, $result);
        $this->assertInstanceOf(ArvatoRssQuoteDataTransfer::class, $result->getArvatoRssQuoteData());
        $this->assertInstanceOf(
            ArvatoRssStoreOrderResponseTransfer::class,
            $result->getArvatoRssQuoteData()
                ->getArvatoRssRiskCheckResponse()
        );
    }
}
