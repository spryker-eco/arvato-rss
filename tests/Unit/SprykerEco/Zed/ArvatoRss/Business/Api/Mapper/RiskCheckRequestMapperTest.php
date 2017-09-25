<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\TestCase;
use SprykerEco\Service\ArvatoRss\Iso3166Converter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyBridge;

class RiskCheckRequestMapperTest extends TestCase
{

    const INT_VALUE = 12475;
    const DECIMAL_VALUE = 124.75;

    /**
     * @dataProvider userData
     */
    public function testMapQuoteToRequestTranfer($data)
    {
        $mapper = $this->createMapper();

        $quoteTranfer = $this->getQuoteTranfer($data);
        $expected = $this->getExpectedRequestTransfer($data)->toArray(true);
        $actual = $mapper->mapQuoteToRequest($quoteTranfer)->toArray(true);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function userDataProvider()
    {
        return [
            [
                new \ArrayObject(
                    [
                        'clientId'          => '00000000',
                        'authorisation'     => '11111111',
                        'country'           => 'DE',
                        'city'              => 'Berlin',
                        'street'            => 'Europa-Allee 50',
                        'zipCode'           => '60327',
                        'firstName'         => 'Michael',
                        'lastName'          => 'Duglas',
                        'salutation'        => 'Mr.',
                        'email'             => 'duglas@gmail.com',
                        'telephoneNumber'   => '123213',
                        'birthDay'          => '20/04/1978',
                        'position'          => 1,
                        'productNumber'     => '777777',
                        'unitPrice'         => static::INT_VALUE,
                        'unitCount'         => 1
                    ]
                )
            ]
        ];
    }

    /**
     * @param \ArrayObject $data
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function getQuoteTranfer($data)
    {
        $quoteTransfer = new QuoteTransfer();
        $customerTranfer = new CustomerTransfer();
        $billingAddress = new AddressTransfer();
        $orderItem = new ItemTransfer();

        $billingAddress->setIso2Code($data->getCountry());
        $billingAddress->setCity($data->getCity());
        $billingAddress->setAddress1($data->getStreet());
        $billingAddress->setZipCode($data->getZipCode());

        $customerTranfer->setFirstName($data->getFirstName());
        $customerTranfer->setLastName($data->getLastName());
        $customerTranfer->setSalutation($data->getSalutation());
        $customerTranfer->setEmail($data->getEmail());
        $customerTranfer->setPhone($data->getPhoneNumber());
        $customerTranfer->setDateOfBirth($data->getBirthDay());

        $orderItem->setUnitPrice($data->getUnitPrice());
        $orderItem->setSku($data->getProductNumber());

        $quoteTransfer->setCustomer($customerTranfer);
        $quoteTransfer->setBillingAddress($billingAddress);
        $quoteTransfer->addItem($orderItem);

        return $quoteTransfer;
    }

    /**
     * @param \ArrayObject $data
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function getExpectedRequestTransfer($data)
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();
        $identificationTransfer = new ArvatoRssIdentificationRequestTransfer();
        $billingCustomerTransfer = new ArvatoRssBillingCustomerTransfer();
        $address = new ArvatoRssCustomerAddressTransfer();
        $orderTransfer = new ArvatoRssOrderTransfer();
        $itemTransfer = new ArvatoRssOrderItemTransfer();

        $identificationTransfer->setClientId($data->getClientId());
        $identificationTransfer->setAuthorisation($data->getAuthorisation());

        $address->setCountry($data->getCountry());
        $address->setCity($data->getCity());
        $address->setStreet($data->getStreet());
        $address->setZipCode($data->getZipCode());
        $billingCustomerTransfer->setAddress($address);
        $billingCustomerTransfer->setFirstName($data->getFirstName());
        $billingCustomerTransfer->setLastName($data->getLastName());
        $billingCustomerTransfer->setSalutation($data->getSalutation());
        $billingCustomerTransfer->setEmail($data->getEmail());
        $billingCustomerTransfer->setTelephoneNumber($data->getTelephoneNumber());
        $billingCustomerTransfer->setBirthDay($data->getBirthDay());

        $itemTransfer->setPosition($data->getPosition());
        $itemTransfer->setProductNumber($data->getProductNumber());
        $itemTransfer->setUnitPrice(static::INT_VALUE);
        $itemTransfer->setUnitCount(1);

        $orderTransfer->addItem($itemTransfer);
        $requestTransfer->setIdentification($identificationTransfer);
        $requestTransfer->setBillingCustomer($billingCustomerTransfer);
        $requestTransfer->setOrder($orderTransfer);

        return $requestTransfer;
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper
     */
    protected function createMapper()
    {
        return new RiskCheckRequestMapper(
            $this->createMoneyFacadeMock(),
            $this->createConverter()
        );
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

    /**
     * @return \SprykerEco\Service\ArvatoRss\Iso3166Converter
     */
    protected function createConverter()
    {
        return new Iso3166Converter();
    }

}