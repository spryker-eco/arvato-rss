<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper;
use SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect\AbstractMapperTest;

class RiskCheckRequestMapperTest extends AbstractMapperTest
{
    /**
     * @return void
     */
    public function testMapQuoteToRequestTranfer()
    {
        $quoteTransfer = $this->createQuoteTransfer();

        $mapper = new RiskCheckRequestMapper(
            $this->createIdentificationMapperMock(),
            $this->createBillingCustomerMapperMock(),
            $this->createOrderMapperMock()
        );
        $result = $mapper->mapQuoteToRequestTranfer($quoteTransfer);
        $this->testResult($result);
    }

    /**
     * @return void
     */
    protected function testResult($result)
    {
        $this->assertInstanceOf(ArvatoRssRiskCheckRequestTransfer::class, $result);
        $this->assertInstanceOf(IdentificationMapperInterface::class, $result->getIdentification());
        $this->assertInstanceOf(BillingCustomerMapperInterface::class, $result->getBillingCustomer());
        $this->assertInstanceOf(OrderMapperInterface::class, $result->getOrder());
    }

    protected function createIdentificationMapperMock()
    {
        $moneyFacadeMock = $this->createPartialMock(
            IdentificationMapperInterface::class,
            ['map']
        );
        $moneyFacadeMock->method('map')
            ->willReturn(new ArvatoRssIdentificationRequestTransfer());

        return $moneyFacadeMock;
    }

    protected function createBillingCustomerMapperMock()
    {
        $moneyFacadeMock = $this->createPartialMock(
            BillingCustomerMapperInterface::class,
            ['map']
        );
        $moneyFacadeMock->method('map')
            ->willReturn(new ArvatoRssBillingCustomerTransfer());

        return $moneyFacadeMock;
    }

    protected function createOrderMapperMock()
    {
        $moneyFacadeMock = $this->createPartialMock(
            OrderMapperInterface::class,
            ['map']
        );
        $moneyFacadeMock->method('map')
            ->willReturn(new ArvatoRssOrderTransfer());

        return $moneyFacadeMock;
    }
}
