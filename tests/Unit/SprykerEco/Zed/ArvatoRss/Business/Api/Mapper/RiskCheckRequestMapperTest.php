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
     * @param \ArrayObject $data
     *
     * @return void
     */
    public function testMapQuoteToRequestTranfer(ArrayObject $data)
    {
        $quoteTranfer = $this->helper->createQuoteTransfer($data);
        $mapper = $this->helper->createRequestMapper($this->createMoneyFacadeMock());

        $expected = $this->getExpectedRequestTransfer($data)->toArray(true);

        $actual = $mapper->mapQuoteToRequestTranfer($quoteTranfer)->toArray(true);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function userDataProvider()
    {
        return [
            [
                new ArrayObject(
                    [
                        'clientId' => Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_CLIENTID],
                        'authorisation' => Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_PASSWORD],
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
                        'unitPrice' => static::INT_VALUE,
                        'unitCount' => 1,
                    ],
                    ArrayObject::ARRAY_AS_PROPS
                )
            ],
        ];
    }

    /**
     * @param \ArrayObject $data
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function getExpectedRequestTransfer(ArrayObject $data)
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();
        $identificationTransfer = new ArvatoRssIdentificationRequestTransfer();
        $billingCustomerTransfer = new ArvatoRssBillingCustomerTransfer();
        $address = new ArvatoRssCustomerAddressTransfer();
        $orderTransfer = new ArvatoRssOrderTransfer();
        $itemTransfer = new ArvatoRssOrderItemTransfer();

        $identificationTransfer->setClientId($data->clientId);
        $identificationTransfer->setAuthorisation($data->authorisation);

        $address->setCountry(
            $this->helper->createConverter()->iso2ToNumeric($data->country)
        );
        $address->setCity($data->city);
        $address->setStreet($data->street);
        $address->setStreetNumber($data->streetNumber);
        $address->setZipCode($data->zipCode);
        $billingCustomerTransfer->setAddress($address);
        $billingCustomerTransfer->setFirstName($data->firstName);
        $billingCustomerTransfer->setLastName($data->lastName);
        $billingCustomerTransfer->setSalutation($data->salutation);
        $billingCustomerTransfer->setEmail($data->email);
        $billingCustomerTransfer->setTelephoneNumber($data->phoneNumber);
        $billingCustomerTransfer->setBirthDay($data->birthDay);

        $itemTransfer->setProductNumber($data->productNumber);
        $itemTransfer->setUnitPrice(static::DECIMAL_VALUE);
        $itemTransfer->setUnitCount(static::UNIT_COUNT);
        $itemTransfer->setProductGroupId(static::PRODUCT_GROUP_ID);

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
