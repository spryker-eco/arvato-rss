<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Zed\ArvatoRss\ArvatoRssConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderCallRequestMapper;
use SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepository;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;

class StoreOrderRequestMapperTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function testMapQuoteToRequestTranfer()
    {
        $mapper = new StoreOrderCallRequestMapper(
            $this->createIdentificationMapperMock(),
            $this->createOrderMapperMock(),
            new ArvatoRssRepository(),
            new ArvatoRssConfig()
        );
        $result = $mapper->mapOrderToRequestTransfer($this->order);
        $this->testResult($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer $result
     *
     * @return void
     */
    protected function testResult(ArvatoRssStoreOrderRequestTransfer $result)
    {
        $this->assertInstanceOf(ArvatoRssStoreOrderRequestTransfer::class, $result);
        $this->assertInstanceOf(ArvatoRssIdentificationRequestTransfer::class, $result->getIdentification());
        $this->assertInstanceOf(ArvatoRssOrderTransfer::class, $result->getOrder());
        $this->assertEquals(
            $result->getOrder()->getPaymentType(),
            ArvatoRssApiConfig::INVOICE
        );
        $this->assertEquals(
            $result->getOrder()->getDebitorNumber(),
            $this->order->getCustomer()->getCustomerReference()
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createIdentificationMapperMock()
    {
        $identificationMapperMock = $this->createPartialMock(
            IdentificationMapperInterface::class,
            ['map']
        );
        $identificationMapperMock->method('map')
            ->willReturn(new ArvatoRssIdentificationRequestTransfer());

        return $identificationMapperMock;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createOrderMapperMock()
    {
        $orderMapperMock = $this->createPartialMock(
            OrderMapperInterface::class,
            ['map']
        );
        $orderMapperMock->method('map')
            ->willReturn(new ArvatoRssOrderTransfer());

        return $orderMapperMock;
    }
}
