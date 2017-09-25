<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use PHPUnit\Framework\TestCase;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter;

class RiskCheckRequestConverterTest extends TestCase
{

    /**
     * @dataProvider transfer
     *
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $data
     *
     * @return void
     */
    public function testConvert($data)
    {
        $converter = $this->createRiskCheckToRequestConverter();
        $expected = $this->createExpectedResult($data);
        $actual = $converter->convert($data);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function transferProvider()
    {
        $order = (new ArvatoRssOrderTransfer())
            ->setTotalOrderValue('124.5')
            ->setGrossTotalBill('124.5')
            ->setCurrency('EUR')
            ->setRegisteredOrder(true)
            ->addItem(
                (new ArvatoRssOrderItemTransfer())
                    ->setProductGroupId(1)
                    ->setProductNumber('123')
                    ->setUnitPrice('123')
                    ->setUnitCount(12)
            );
        $address = (new ArvatoRssCustomerAddressTransfer())
            ->setCountry('DE')
            ->setCity('Berlin')
            ->setStreet('Lützowplatz')
            ->setStreetNumber('17')
            ->setZipCode('10785');
        $billingCustomer = (new ArvatoRssBillingCustomerTransfer())
            ->setEmail('berlin@de.com')
            ->setSalutation('Mr.')
            ->setFirstName('Bob')
            ->setLastName('Marley')
            ->setBirthDay('12-18-2001')
            ->setTelephoneNumber('123123')
            ->setAddress($address);
        $requestTransfer = (new ArvatoRssRiskCheckRequestTransfer())
            ->setBillingCustomer($billingCustomer)
            ->setOrder($order);

        return [
            $requestTransfer
        ];
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter
     */
    protected function createRiskCheckToRequestConverter()
    {
        return new RiskCheckRequestConverter();
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer $data
     *
     * @return array
     */
    protected function createExpectedResult($data)
    {
        $addressTranfer = $data->getAddress();
        $billingCustomerTransfer = $data->getBillingCustomer();
        $address = [
            'Country' => $addressTranfer->getCountry(),
            'City' => $addressTranfer->getCity(),
            'Street' => $addressTranfer->getStreet(),
            'ZipCode' => $addressTranfer->getZipCode(),
        ];
        $result['BillingCustomer'] = [
            'FirstName' => $billingCustomerTransfer->getFirstName(),
            'LastName' => $billingCustomerTransfer->getLastName(),
            'Address' => $address,
        ];

        $order = $data->getOrder();

        $result['Order'] = [
            'RegisteredOrder' => true,
            'Currency' => $order->getCurrency(),
            'GrossTotalBill' => $order->getGrossTotalBill(),
            'TotalOrderValue' => $order->getTotalOrderValue(),
        ];

        $result['Order']['Item'] = [];

        foreach ($order->getItem() as $item) {
            $result['Order']['Item'][] = [
                'ProductNumber' => $item->getProductNumber(),
                'ProductGroupId' => $item->getProductGroupId(),
                'UnitPrice' => $item->getUnitPrice(),
                'UnitCount' => $item->getUnitCount(),
            ];
        }

        return $result;
    }

}
