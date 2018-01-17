<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
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
        $result = $this->convertBillingCustomer($arvatoRssRiskCheckRequestTransfer);
        if ($arvatoRssRiskCheckRequestTransfer->getDeliveryCustomer()) {
            $result += $this->convertDeliveryCustomer($arvatoRssRiskCheckRequestTransfer);
        }
        $result += $this->convertOrder($arvatoRssRiskCheckRequestTransfer);

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
        $customerAddressTransfer = $billingCustomerTransfer->getAddress();
        $result[ArvatoRssRequestApiConfig::ARVATORSS_API_BILLINGCUSTOMER] = [
            ArvatoRssRequestApiConfig::ARVATORSS_API_FIRSTNAME => $billingCustomerTransfer->getFirstName(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_LASTNAME => $billingCustomerTransfer->getLastName(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS => $this->convertCustomerAddress($customerAddressTransfer),
        ];

        return $result;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     *
     * @return array
     */
    protected function convertDeliveryCustomer(ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer)
    {
        $result = [];
        $deliveryCustomerTransfer = $arvatoRssRiskCheckRequestTransfer->getDeliveryCustomer();
        $customerAddressTransfer = $deliveryCustomerTransfer->getAddress();
        $result[ArvatoRssRequestApiConfig::ARVATORSS_API_DELIVERYCUSTOMER] = [
            ArvatoRssRequestApiConfig::ARVATORSS_API_FIRSTNAME => $deliveryCustomerTransfer->getFirstName(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_LASTNAME => $deliveryCustomerTransfer->getLastName(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_ADDRESS => $this->convertCustomerAddress($customerAddressTransfer),
        ];

        return $result;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer $customerAddressTransfer
     *
     * @return array
     */
    protected function convertCustomerAddress(ArvatoRssCustomerAddressTransfer $customerAddressTransfer)
    {
        return [
            ArvatoRssRequestApiConfig::ARVATORSS_API_COUNTRY => $customerAddressTransfer->getCountry(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_CITY => $customerAddressTransfer->getCity(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_STREET => $customerAddressTransfer->getStreet(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_STREET_NUMBER => $customerAddressTransfer->getStreetNumber(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_ZIPCODE => $customerAddressTransfer->getZipCode(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_STREET_NUMBER_ADDITIONAL => $customerAddressTransfer->getStreetNumberAdditional(),
        ];
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
