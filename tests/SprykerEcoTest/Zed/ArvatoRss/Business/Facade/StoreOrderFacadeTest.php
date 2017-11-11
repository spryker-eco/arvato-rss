<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Facade;

use Generated\Shared\Transfer\ArvatoRssQuoteDataTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEcoTest\Zed\ArvatoRss\Mock\ArvatoRssBusinessFactoryMock;
use SprykerTest\Shared\Testify\Helper\BusinessHelper;

class StoreOrderFacadeTest extends AbstractFacadeTest
{
    /**
     * @return void
     */
    public function testPerformRiskCheck()
    {
        $facade = $this->getModule('\\' . BusinessHelper::class)->getFacade();
        $facade->setFactory(
            new ArvatoRssBusinessFactoryMock()
        );
        $response = $facade->storeOrder($this->quote);
        $this->testResponse($response);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $response
     *
     * @return void
     */
    protected function testResponse(QuoteTransfer $response)
    {
        $this->assertInstanceOf(ArvatoRssQuoteDataTransfer::class, $response->getArvatoRssQuoteData());
        $this->assertInstanceOf(
            ArvatoRssStoreOrderResponseTransfer::class,
            $response->getArvatoRssQuoteData()
                ->getArvatoRssStoreOrderResponse()
        );

        $riskCheckResponse = $response->getArvatoRssQuoteData()->getArvatoRssStoreOrderResponse();
        $this->assertEquals(static::RESPONSE_STRING_FIElD_VALUE, $riskCheckResponse->getResult());
        $this->assertEquals(static::RESPONSE_STRING_FIElD_VALUE, $riskCheckResponse->getErrorMessage());
        $this->assertEquals(static::IS_ERROR, $riskCheckResponse->getIsError());
    }
}
