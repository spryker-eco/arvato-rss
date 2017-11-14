<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterService;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapper;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;

class BillingCustomerMapperTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function testMap()
    {
        $mapper = new BillingCustomerMapper(
            new Iso3166ConverterService()
        );
        $result = $mapper->map(
            $this->quote->getBillingAddress(),
            $this->quote->getCustomer()
        );
        $this->testResult($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer $result
     *
     * @return void
     */
    protected function testResult(ArvatoRssBillingCustomerTransfer $result)
    {
        $address = $result->getAddress();
        $this->assertInstanceOf(ArvatoRssCustomerAddressTransfer::class, $address);

        $this->assertEquals($result->getFirstName(), $this->quote->getBillingAddress()->getFirstName());
        $this->assertEquals($result->getLastName(), $this->quote->getBillingAddress()->getLastName());
        $this->assertEquals($result->getTelephoneNumber(), $this->quote->getBillingAddress()->getPhone());
        $this->assertEquals($result->getEmail(), $this->quote->getCustomer()->getEmail());
        $this->assertEquals($result->getSalutation(), strtoupper($this->quote->getCustomer()->getSalutation()));
    }
}
