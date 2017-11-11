<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\DataBuilder\StoreBuilder;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapper;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToStoreInterface;

class OrderMapperTest extends AbstractMapperTest
{
    /**
     * @const double DECIMAL_VALUE
     */
    const DECIMAL_VALUE = 124.75;

    /**
     * @return void
     */
    public function testMap()
    {
        $mapper = new OrderMapper(
            $this->createMoneyFacadeMock(),
            $this->createStoreFacadeMock()
        );
        $result = $mapper->map($this->quote);

        $this->testResult($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssOrderTransfer $result
     *
     * @return void
     */
    protected function testResult(ArvatoRssOrderTransfer $result)
    {
        $this->assertEquals(
            $result->getCurrency(),
            $this->createStoreFacadeMock()
                ->getCurrentStore()
                ->getSelectedCurrencyIsoCode()
        );
        $this->assertEquals($result->getPaymentType(), $this->quote->getPayment()->getPaymentMethod());
        $this->assertEquals($result->getGrossTotalBill(), static::DECIMAL_VALUE);
        $this->assertEquals($result->getTotalOrderValue(), static::DECIMAL_VALUE);
        $this->assertEquals(count($result->getItems()), count($this->quote->getItems()));
        $this->assertEquals($result->getOrderNumber(), $this->quote->getOrderReference());
        $this->assertEquals($result->getDebitorNumber(), $this->quote->getCustomer()->getIdCustomer());
        $this->assertEquals($result->getRegisteredOrder(), true);
    }

    protected function createMoneyFacadeMock()
    {
        $moneyFacadeMock = $this->createPartialMock(
            ArvatoRssToMoneyInterface::class,
            ['convertIntegerToDecimal', 'convertDecimalToInteger']
        );
        $moneyFacadeMock->method('convertIntegerToDecimal')
            ->willReturn(static::DECIMAL_VALUE);

        return $moneyFacadeMock;
    }

    protected function createStoreFacadeMock()
    {
        $storeFacadeMock = $this->createPartialMock(
            ArvatoRssToStoreInterface::class,
            ['getCurrentStore']
        );
        $storeFacadeMock->method('getCurrentStore')
            ->willReturn(
                (new StoreBuilder())
                    ->build()
            );

        return $storeFacadeMock;
    }
}
