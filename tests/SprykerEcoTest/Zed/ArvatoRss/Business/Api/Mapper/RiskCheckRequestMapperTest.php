<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssDeliveryCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\DeliveryCustomerMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;

class RiskCheckRequestMapperTest extends AbstractBusinessTest
{
    /**
     * @param bool $billingSameAsShipping
     *
     * @dataProvider provideQuoteData
     *
     * @return void
     */
    public function testMapQuoteToRequestTranfer($billingSameAsShipping)
    {
        $mapper = new RiskCheckRequestMapper(
            $this->createIdentificationMapperMock(),
            $this->createBillingCustomerMapperMock(),
            $this->createDeliveryCustomerMapperMock(),
            $this->createOrderMapperMock()
        );
        $quote = $this->quote;
        $quote->setBillingSameAsShipping($billingSameAsShipping);
        $result = $mapper->mapQuoteToRequestTranfer($quote);
        $this->testResult($quote, $result);
    }

    /**
     * @param QuoteTransfer $quote
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $result
     *
     * @return void
     */
    protected function testResult(QuoteTransfer $quote, $result)
    {
        $this->assertInstanceOf(ArvatoRssRiskCheckRequestTransfer::class, $result);
        $this->assertInstanceOf(ArvatoRssIdentificationRequestTransfer::class, $result->getIdentification());
        $this->assertInstanceOf(ArvatoRssBillingCustomerTransfer::class, $result->getBillingCustomer());
        $this->assertInstanceOf(ArvatoRssOrderTransfer::class, $result->getOrder());
        $this->assertNotEquals($quote->getBillingSameAsShipping(), (bool) $result->getDeliveryCustomer());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
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

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createDeliveryCustomerMapperMock()
    {
        $moneyFacadeMock = $this->createPartialMock(
            DeliveryCustomerMapperInterface::class,
            ['map']
        );
        $moneyFacadeMock->method('map')
            ->willReturn(new ArvatoRssDeliveryCustomerTransfer());

        return $moneyFacadeMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
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

    /**
     * @return array
     */
    public static function provideQuoteData()
    {
        return [
            'quote: billing not equal delivery' => [false],
            'quote: billing equal delivery' => [true],
        ];
    }
}
