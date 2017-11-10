<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\QuoteBuilder;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyBridge;

class AbstractMapperTest extends Test
{
    /**
     * @const double DECIMAL_VALUE
     */
    const DECIMAL_VALUE = 124.75;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quote;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->quote = $this->createQuoteTransfer();
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createQuoteTransfer()
    {
        return (new QuoteBuilder())
            ->withBillingAddress()
            ->withCustomer()
            ->withTotals()
            ->withItem()
            ->build();
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMoneyFacadeMock()
    {
        $moneyFacadeMock = $this->createPartialMock(
            ArvatoRssToMoneyBridge::class,
            ['convertIntegerToDecimal']
        );
        $moneyFacadeMock->method('convertIntegerToDecimal')
            ->willReturn(static::DECIMAL_VALUE);

        return $moneyFacadeMock;
    }
}
