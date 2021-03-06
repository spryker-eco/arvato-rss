<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssQuoteDataTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;

class RiskCheckResponseMapperTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function testMapResponseToQuote()
    {
        $mapper = new RiskCheckResponseMapper();
        $result = $mapper->mapResponseToQuote(new ArvatoRssRiskCheckResponseTransfer(), $this->quote);
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
            ArvatoRssRiskCheckResponseTransfer::class,
            $result->getArvatoRssQuoteData()
                ->getArvatoRssRiskCheckResponse()
        );
    }
}
