<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapper;

class OrderMapperTest extends AbstractMapperTest
{
    /**
     * @return void
     */
    public function testMap()
    {
        $mapper = new OrderMapper(
            $this->createMoneyFacadeMock()
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
        $this->assertEquals($result->getCurrency(), $this->quote->getCurrency());
        $this->assertEquals($result->getPaymentType(), $this->quote->getPayment()->getPaymentMethod());
        $this->assertEquals($result->getGrossTotalBill(), $this->quote->getTotals()->getGrandTotal());
        $this->assertEquals($result->getTotalOrderValue(), $this->quote->getTotals()->getGrandTotal());
        $this->assertEquals(count($result->getItems()), count($this->quote->getItems()));
        $this->assertEquals($result->getOrderNumber(), $this->quote->getOrderReference());
        $this->assertEquals($result->getDebitorNumber(), $this->quote->getCustomer()->getIdCustomer());
        $this->assertEquals($result->getRegisteredOrder(), true);
    }
}
