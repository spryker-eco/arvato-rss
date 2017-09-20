<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;

class RiskCheckRequestConverter implements RiskCheckRequestConverterInterface
{

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     *
     * @return array
     */
    public function convert(ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer)
    {
        $result = [];

        $billingCustomer = $this->convertBillingCustomer($arvatoRssRiskCheckRequestTransfer);
        $order = $this->convertOrder($arvatoRssRiskCheckRequestTransfer);

        $result = array_merge($result, $billingCustomer);
        $result = array_merge($result, $order);

        return $result;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     *
     * @return array
     */
    protected function convertBillingCustomer(ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer)
    {
        $result = [];
        $billingCustomerTransfer = $arvatoRssRiskCheckRequestTransfer->getBillingCustomer();
        $addressTranfer = $billingCustomerTransfer->getAddress();
        $address = [
            'Country' => $addressTranfer->getCountry(),
            'City' => $addressTranfer->getCity(),
            'Street' => $addressTranfer->getStreet(),
            'ZipCode' => $addressTranfer->getZipCode()
        ];
        $result['BillingCustomer'] = [
            'FirstName' => $billingCustomerTransfer->getFirstName(),
            'LastName'  => $billingCustomerTransfer->getLastName(),
            'Address'   => $address
        ];

        return $result;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     *
     * @return array
     */
    protected function convertOrder(ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer)
    {
        $result = [];
        $order = $arvatoRssRiskCheckRequestTransfer->getOrder();

        $result['Order'] = [
            //TODO: Clarify what it means
            'RegisteredOrder' => true,
            'Currency' => $order->getCurrency(),
            'GrossTotalBill' => $order->getGrossTotalBill(),
            'TotalOrderValue' => $order->getTotalOrderValue()
        ];
        // TODO: deal with items.
        /*$result['Order']['Item'] = [];
        foreach ($order->getItem() as $item) {
            $result['Order']['Item'][] = [
                //TODO: clarify this. Is it sku?
                'ProductNumber' => $item->getProductNumber(),
                //TODO: clarify
                'ProductGroupId' => $item->getProductGroupId(),
                'UnitPrice' => $item->getUnitPrice(),
                'UnitCount' => $item->getUnitCount()
            ];
        }*/

        return $result;
    }
}