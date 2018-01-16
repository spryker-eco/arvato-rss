<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Converter;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\ArvatoRssBillingCustomerBuilder;
use Generated\Shared\DataBuilder\ArvatoRssCustomerAddressBuilder;
use Generated\Shared\DataBuilder\ArvatoRssDeliveryCustomerBuilder;
use Generated\Shared\DataBuilder\ArvatoRssRiskCheckRequestBuilder;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter;

class RiskCheckRequestConverterTest extends Test
{
    /**
     * @param ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @dataProvider provideRequestTransferData
     *
     * @return void
     */
    public function testConvert(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $converter = new RiskCheckRequestConverter();
        $result = $converter->convert($requestTransfer);
        $this->testResult($result, $requestTransfer);
    }

    /**
     * @param array $result
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTranfer
     *
     * @return void
     */
    protected function testResult(array $result, ArvatoRssRiskCheckRequestTransfer $requestTranfer)
    {
        $billingCustomer = $result[ArvatoRssRequestApiConfig::ARVATORSS_API_BILLINGCUSTOMER];

        $this->assertNotEmpty($billingCustomer);
        $this->assertNotEmpty($billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS]);
        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConfig::ARVATORSS_API_COUNTRY],
            $requestTranfer->getBillingCustomer()->getAddress()->getCountry()
        );
        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConfig::ARVATORSS_API_CITY],
            $requestTranfer->getBillingCustomer()->getAddress()->getCity()
        );
        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConfig::ARVATORSS_API_STREET],
            $requestTranfer->getBillingCustomer()->getAddress()->getStreet()
        );
        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConfig::ARVATORSS_API_STREET_NUMBER],
            $requestTranfer->getBillingCustomer()->getAddress()->getStreetNumber()
        );
        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConfig::ARVATORSS_API_ZIPCODE],
            $requestTranfer->getBillingCustomer()->getAddress()->getZipCode()
        );
        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS][ArvatoRssRequestApiConfig::ARVATORSS_API_STREET_NUMBER_ADDITIONAL],
            $requestTranfer->getBillingCustomer()->getAddress()->getStreetNumberAdditional()
        );

        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_FIRSTNAME],
            $requestTranfer->getBillingCustomer()->getFirstName()
        );
        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_LASTNAME],
            $requestTranfer->getBillingCustomer()->getLastName()
        );
        $this->assertEquals(
            $billingCustomer[ArvatoRssRequestApiConfig::ARVATORSS_API_LASTNAME],
            $requestTranfer->getBillingCustomer()->getLastName()
        );

        $order = $result[ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER];
        $this->assertNotEmpty($order);

        $this->assertEquals(
            $order[ArvatoRssRequestApiConfig::ARVATORSS_API_REGISTEREDORDER],
            $requestTranfer->getOrder()->getRegisteredOrder()
        );
        $this->assertEquals(
            $order[ArvatoRssRequestApiConfig::ARVATORSS_API_CURRENCY],
            $requestTranfer->getOrder()->getCurrency()
        );
        $this->assertEquals(
            $order[ArvatoRssRequestApiConfig::ARVATORSS_API_GROSSTOTALBILL],
            $requestTranfer->getOrder()->getGrossTotalBill()
        );
        $this->assertEquals(
            $order[ArvatoRssRequestApiConfig::ARVATORSS_API_TOTALORDERVALUE],
            $requestTranfer->getOrder()->getTotalOrderValue()
        );

        foreach ($order[ArvatoRssRequestApiConfig::ARVATORSS_API_ITEM] as $key => $item) {
            $this->assertArrayHasKey($key, $requestTranfer->getOrder()->getItems());
            $this->assertEquals(
                $item[ArvatoRssRequestApiConfig::ARVATORSS_API_PRODUCTNUMBER],
                $requestTranfer->getOrder()->getItems()[$key]->getProductNumber()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConfig::ARVATORSS_API_PRODUCTGROUPID],
                $requestTranfer->getOrder()->getItems()[$key]->getProductGroupId()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConfig::ARVATORSS_API_UNITPRICE],
                $requestTranfer->getOrder()->getItems()[$key]->getUnitPrice()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConfig::ARVATORSS_API_UNITCOUNT],
                $requestTranfer->getOrder()->getItems()[$key]->getUnitCount()
            );
        }
    }

    /**
     * @return array
     */
    public static function provideRequestTransferData()
    {
        $requestWithAdditionalAddress = (new ArvatoRssRiskCheckRequestBuilder())
            ->withIdentification()
            ->withBillingCustomer((new ArvatoRssBillingCustomerBuilder())->withAddress())
            ->withDeliveryCustomer((new ArvatoRssDeliveryCustomerBuilder())->withAddress())
            ->withOrder()
            ->build();
        $requestWithoutAdditionalAddress = (new ArvatoRssRiskCheckRequestBuilder())
            ->withIdentification()
            ->withBillingCustomer(
                (new ArvatoRssBillingCustomerBuilder())->withAddress(
                    (new ArvatoRssCustomerAddressBuilder())->except(['streetNumberAdditional'])
                )
            )
            ->withDeliveryCustomer(
                (new ArvatoRssDeliveryCustomerBuilder())->withAddress(
                    (new ArvatoRssCustomerAddressBuilder())->except(['streetNumberAdditional'])
                )
            )
            ->withOrder()
            ->build();
        return [
            'with additional address' => [$requestWithAdditionalAddress],
            'without additional address' => [$requestWithoutAdditionalAddress]
        ];
    }
}
