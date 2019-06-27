<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Facade;

use Generated\Shared\Transfer\ArvatoRssQuoteDataTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;
use SprykerEcoTest\Zed\ArvatoRss\Mock\ArvatoRssBusinessFactoryMock;

class RiskCheckFacadeTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function testPerformRiskCheck(): void
    {
        /** @var \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacade $facade */
        $facade = $this->tester->getFacade();
        $facade->setFactory(new ArvatoRssBusinessFactoryMock());
        $response = $facade->performRiskCheck($this->quote);
        $this->testResponse($response);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $response
     *
     * @return void
     */
    protected function testResponse(QuoteTransfer $response): void
    {
        $this->assertInstanceOf(ArvatoRssQuoteDataTransfer::class, $response->getArvatoRssQuoteData());
        $this->assertInstanceOf(
            ArvatoRssRiskCheckResponseTransfer::class,
            $response->getArvatoRssQuoteData()
                ->getArvatoRssRiskCheckResponse()
        );

        $riskCheckResponse = $response->getArvatoRssQuoteData()->getArvatoRssRiskCheckResponse();
        $this->assertEquals(static::RESPONSE_STRING_FIELD_VALUE, $riskCheckResponse->getResult());
        $this->assertEquals(static::RESPONSE_STRING_FIELD_VALUE, $riskCheckResponse->getErrorMessage());
        $this->assertEquals(static::RESPONSE_STRING_FIELD_VALUE, $riskCheckResponse->getResultCode());
        $this->assertEquals(static::RESPONSE_STRING_FIELD_VALUE, $riskCheckResponse->getActionCode());
        $this->assertFalse($riskCheckResponse->getIsError());
    }
}
