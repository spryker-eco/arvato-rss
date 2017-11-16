<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConfig;

class RiskCheckRequestConverter implements RiskCheckRequestConverterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     *
     * @return array
     */
    public function convert(ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer)
    {
        $billingCustomer = $this->convertBillingCustomer($arvatoRssRiskCheckRequestTransfer);
        $order = $this->convertOrder($arvatoRssRiskCheckRequestTransfer);

        return $billingCustomer + $order;
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
            ArvatoRssRequestApiConfig::ARVATORSS_API_COUNTRY => $addressTranfer->getCountry(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_CITY => $addressTranfer->getCity(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_STREET => $addressTranfer->getStreet(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_STREET_NUMBER => $addressTranfer->getStreetNumber(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_ZIPCODE => $addressTranfer->getZipCode(),
        ];
        $result[ArvatoRssRequestApiConfig::ARVATORSS_API_BILLINGCUSTOMER] = [
            ArvatoRssRequestApiConfig::ARVATORSS_API_FIRSTNAME => $billingCustomerTransfer->getFirstName(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_LASTNAME => $billingCustomerTransfer->getLastName(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS => $address,
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

        $result[ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER] = [
            ArvatoRssRequestApiConfig::ARVATORSS_API_REGISTEREDORDER => $order->getRegisteredOrder(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_CURRENCY => $order->getCurrency(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_GROSSTOTALBILL => $order->getGrossTotalBill(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_TOTALORDERVALUE => $order->getTotalOrderValue(),
        ];
        $result[ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER][ArvatoRssRequestApiConfig::ARVATORSS_API_ITEM] = [];

        foreach ($order->getItems() as $item) {
            $result[ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER][ArvatoRssRequestApiConfig::ARVATORSS_API_ITEM][] = [
                ArvatoRssRequestApiConfig::ARVATORSS_API_PRODUCTNUMBER => $item->getProductNumber(),
                ArvatoRssRequestApiConfig::ARVATORSS_API_PRODUCTGROUPID => $item->getProductGroupId(),
                ArvatoRssRequestApiConfig::ARVATORSS_API_UNITPRICE => $item->getUnitPrice(),
                ArvatoRssRequestApiConfig::ARVATORSS_API_UNITCOUNT => $item->getUnitCount(),
            ];
        }

        return $result;
    }
}
