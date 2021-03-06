<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\DataBuilder\StoreBuilder;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\OrderMapperTransfer;
use SprykerEco\Zed\ArvatoRss\ArvatoRssConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapper;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToStoreInterface;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;

class OrderMapperTest extends AbstractBusinessTest
{
    /**
     * @const float
     */
    public const VALUE_DECIMAL = 124.75;

    /**
     * @return void
     */
    public function testMap()
    {
        $mapper = new OrderMapper(
            $this->createMoneyFacadeMock(),
            $this->createStoreFacadeMock(),
            new ArvatoRssConfig()
        );
        $result = $mapper->map(
            (new OrderMapperTransfer())
                ->setTotals($this->quote->getTotals())
                ->setItems($this->quote->getItems())
                ->setCustomerIsGuest($this->quote->getCustomer()->getIsGuest())
                ->setOrderReference($this->quote->getOrderReference())
        );

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

        $this->assertEquals($result->getGrossTotalBill(), static::VALUE_DECIMAL);
        $this->assertEquals($result->getTotalOrderValue(), static::VALUE_DECIMAL);
        $this->assertEquals(count($result->getItems()), count($this->quote->getItems()));
        $this->assertEquals($result->getOrderNumber(), $this->quote->getOrderReference());
        $this->assertEquals($result->getDebitorNumber(), $this->quote->getCustomer()->getIdCustomer());
        $this->assertEquals($result->getRegisteredOrder(), false);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMoneyFacadeMock()
    {
        $moneyFacadeMock = $this->createPartialMock(
            ArvatoRssToMoneyInterface::class,
            ['convertIntegerToDecimal', 'convertDecimalToInteger']
        );
        $moneyFacadeMock->method('convertIntegerToDecimal')
            ->willReturn(static::VALUE_DECIMAL);

        return $moneyFacadeMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
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
