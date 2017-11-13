<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapper;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;
use SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect\AbstractMapperTest;

class StoreOrderRequestMapperTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function testMapQuoteToRequestTranfer()
    {
        $mapper = new StoreOrderRequestMapper(
            $this->createIdentificationMapperMock(),
            $this->createOrderMapperMock()
        );
        $result = $mapper->mapQuoteToRequestTransfer($this->quote);
        $this->testResult($result);
    }

    /**
     * @return void
     */
    protected function testResult($result)
    {
        $this->assertInstanceOf(ArvatoRssStoreOrderRequestTransfer::class, $result);
        $this->assertInstanceOf(ArvatoRssIdentificationRequestTransfer::class, $result->getIdentification());
        $this->assertInstanceOf(ArvatoRssOrderTransfer::class, $result->getOrder());
    }

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
