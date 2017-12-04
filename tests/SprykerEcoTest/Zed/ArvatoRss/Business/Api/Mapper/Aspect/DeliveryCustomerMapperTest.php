<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\ArvatoRssDeliveryCustomerTransfer;
use Generated\Shared\Transfer\DeliveryCustomerMapperTransfer;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterService;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\DeliveryCustomerMapper;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;

class DeliveryCustomerMapperTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function testMap()
    {
        $mapper = new DeliveryCustomerMapper(
            new Iso3166ConverterService()
        );
        $result = $mapper->map(
            (new DeliveryCustomerMapperTransfer())
                ->setSalutation($this->quote->getCustomer()->getSalutation())
            ->setDeliveryAddress($this->quote->getBillingAddress())
            ->setEmail($this->quote->getBillingAddress()->getEmail())
        );
        $this->testResult($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssDeliveryCustomerTransfer $result
     *
     * @return void
     */
    protected function testResult(ArvatoRssDeliveryCustomerTransfer $result)
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
