<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyBridge;

class RiskCheckRequestMapperTest extends AbstractMapperTest
{

    /**
     * @const int INT_VALUE
     */
    const INT_VALUE = 12475;

    /**
     * @const double DECIMAL_VALUE
     */
    const DECIMAL_VALUE = 124.75;

    /**
     * @const int UNIT_COUNT
     */
    const UNIT_COUNT = 1;

    /**
     * @const int PRODUCT_GROUP_ID
     */
    const PRODUCT_GROUP_ID = 1;

    /**
     * @dataProvider userDataProvider
     *
     * @param \Generated\Shared\Transfer\QuoteTranfer $quoteTransfer
     *
     * @return void
     */
    public function testMapQuoteToRequestTranfer(QuoteTransfer $quoteTransfer)
    {
        $mapper = $this->helper->createRequestMapper($this->createMoneyFacadeMock());
        $expected = $this->getExpectedRequestTransfer($quoteTransfer)->toArray(true);
        $actual = $mapper->mapQuoteToRequestTranfer($quoteTransfer)->toArray(true);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function userDataProvider()
    {
        $data = [
            [
                'clientId' => Config::get(ArvatoRssConstants::ARVATORSS_CLIENTID),
                'authorisation' => Config::get(ArvatoRssConstants::ARVATORSS_AUTHORISATION),
                'country' => 'DE',
                'city' => 'Berlin',
                'street' => 'Europa-Allee 50',
                'streetNumber' => '17',
                'zipCode' => '60327',
                'firstName' => 'Michael',
                'lastName' => 'Duglas',
                'salutation' => 'MR',
                'email' => 'duglas@gmail.com',
                'phoneNumber' => '123213',
                'birthDay' => '1978-10-01',
                'position' => 1,
                'productNumber' => '777777',
                'unitPrice' => 12000,
                'unitCount' => 1,
                'itemQuantity' => 1,
                'grandTotal' => 15000,
                'subTotal' => 14000
            ]
        ];

        return array_map(
            function($arr) {
                return $this->quoteHelper->createQuoteTransfer($arr);
            },
            $data
        );
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTranfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function getExpectedRequestTransfer(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();
        $identificationTransfer = new ArvatoRssIdentificationRequestTransfer();
        $billingCustomerTransfer = new ArvatoRssBillingCustomerTransfer();
        $address = new ArvatoRssCustomerAddressTransfer();
        $orderTransfer = new ArvatoRssOrderTransfer();
        $itemTransfer = new ArvatoRssOrderItemTransfer();

        $identificationTransfer->setClientId($quoteTransfer->getClientId());
        $identificationTransfer->setAuthorisation($quoteTransfer->getAuthorisation());

        $address->setCountry(
            $this->helper->createConverter()->iso2ToNumeric($quoteTransfer->getCountry())
        );
        $address->setCity($quoteTransfer->getCity());
        $address->setStreet($quoteTransfer->getStreet());
        $address->setStreetNumber($quoteTransfer->getStreetNumber());
        $address->setZipCode($quoteTransfer->getZipCode());
        $billingCustomerTransfer->setAddress($address);
        $billingCustomerTransfer->setFirstName($quoteTransfer->getFirstName());
        $billingCustomerTransfer->setLastName($quoteTransfer->getLastName());
        $billingCustomerTransfer->setSalutation($quoteTransfer->getSalutation());
        $billingCustomerTransfer->setEmail($quoteTransfer->getEmail());
        $billingCustomerTransfer->setTelephoneNumber($quoteTransfer->getPhoneNumber());
        $billingCustomerTransfer->setBirthDay($quoteTransfer->getBirthDay());

        $itemTransfer->setProductNumber($quoteTransfer->getProductNumber());
        $itemTransfer->setUnitPrice(static::DECIMAL_VALUE);
        $itemTransfer->setUnitCount($quoteTransfer->getUnitCount());
        $itemTransfer->setProductGroupId($quoteTransfer->getProductGroupId());

        $orderTransfer->addItem($itemTransfer);
        $orderTransfer->setCurrency(Store::getInstance()->getCurrencyIsoCode());
        $orderTransfer->setGrossTotalBill(static::DECIMAL_VALUE);
        $orderTransfer->setTotalOrderValue(static::DECIMAL_VALUE);

        $requestTransfer->setIdentification($identificationTransfer);
        $requestTransfer->setBillingCustomer($billingCustomerTransfer);
        $requestTransfer->setOrder($orderTransfer);

        return $requestTransfer;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createMoneyFacadeMock()
    {
        $moneyFacadeMock = $this->createPartialMock(
            ArvatoRssToMoneyBridge::class,
            ['convertIntegerToDecimal']
        );
        $moneyFacadeMock->method('convertIntegerToDecimal')
            ->willReturn(static::DECIMAL_VALUE);

        return $moneyFacadeMock;
    }

}
