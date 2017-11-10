<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Converter;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\ArvatoRssRiskCheckRequestBuilder;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter;

class RiskCheckRequestConverterTest extends Test
{
    /**
     * @return void
     */
    public function testConvert()
    {
        $converter = new RiskCheckRequestConverter();
        $requestTransfer = (new ArvatoRssRiskCheckRequestBuilder())
            ->withIdentification()
            ->withBillingCustomer()
            ->withOrder()
            ->build();
        $result = $converter->convert($requestTransfer);
        $this->testResult($result, $requestTransfer);
    }

    /**
     * @return void
     */
    protected function testResult(array $result, ArvatoRssRiskCheckRequestTransfer $requestTranfer)
    {
        $this->assertNotEmpty($result[ArvatoRssRequestApiConstants::ARVATORSS_API_ADDRESS]);
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConstants::ARVATORSS_API_COUNTRY],
            $requestTranfer->getBillingCustomer()->getAddress()->getCountry()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConstants::ARVATORSS_API_CITY],
            $requestTranfer->getBillingCustomer()->getAddress()->getCity()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConstants::ARVATORSS_API_STREET],
            $requestTranfer->getBillingCustomer()->getAddress()->getStreet()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConstants::ARVATORSS_API_STREET_NUMBER],
            $requestTranfer->getBillingCustomer()->getAddress()->getStreetNumber()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConstants::ARVATORSS_API_ZIPCODE],
            $requestTranfer->getBillingCustomer()->getAddress()->getZipCode()
        );

        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_BILLINGCUSTOMER][ArvatoRssRequestApiConstants::ARVATORSS_API_FIRSTNAME],
            $requestTranfer->getBillingCustomer()->getFirstName()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_BILLINGCUSTOMER][ArvatoRssRequestApiConstants::ARVATORSS_API_LASTNAME],
            $requestTranfer->getBillingCustomer()->getLastName()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_BILLINGCUSTOMER][ArvatoRssRequestApiConstants::ARVATORSS_API_LASTNAME],
            $requestTranfer->getBillingCustomer()->getLastName()
        );

        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_REGISTEREDORDER],
            $requestTranfer->getOrder()->getRegisteredOrder()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_CURRENCY],
            $requestTranfer->getOrder()->getCurrency()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_GROSSTOTALBILL],
            $requestTranfer->getOrder()->getGrossTotalBill()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_TOTALORDERVALUE],
            $requestTranfer->getOrder()->getTotalOrderValue()
        );

        foreach ($result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_ITEM] as $key => $item) {
            $this->assertArrayHasKey($key, $requestTranfer->getOrder()->getItems());
            $this->assertEquals(
                $item[ArvatoRssRequestApiConstants::ARVATORSS_API_PRODUCTNUMBER],
                $requestTranfer->getOrder()->getItems()[$key]->getProductNumber()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConstants::ARVATORSS_API_PRODUCTGROUPID],
                $requestTranfer->getOrder()->getItems()[$key]->getProductGroupId()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConstants::ARVATORSS_API_UNITPRICE],
                $requestTranfer->getOrder()->getItems()[$key]->getUnitPrice()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConstants::ARVATORSS_API_UNITCOUNT],
                $requestTranfer->getOrder()->getItems()[$key]->getUnitCount()
            );
        }
    }
}
