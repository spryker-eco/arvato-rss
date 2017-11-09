<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConstants;

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
            ArvatoRssRequestApiConstants::ARVATORSS_API_COUNTRY => $addressTranfer->getCountry(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_CITY => $addressTranfer->getCity(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_STREET => $addressTranfer->getStreet(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_STREET_NUMBER => $addressTranfer->getStreetNumber(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_ZIPCODE => $addressTranfer->getZipCode(),
        ];
        $result[ArvatoRssRequestApiConstants::ARVATORSS_API_BILLINGCUSTOMER] = [
            ArvatoRssRequestApiConstants::ARVATORSS_API_FIRSTNAME => $billingCustomerTransfer->getFirstName(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_LASTNAME => $billingCustomerTransfer->getLastName(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_ADDRESS => $address,
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

        $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER] = [
            ArvatoRssRequestApiConstants::ARVATORSS_API_REGISTEREDORDER => true,
            ArvatoRssRequestApiConstants::ARVATORSS_API_CURRENCY => $order->getCurrency(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_GROSSTOTALBILL => $order->getGrossTotalBill(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_TOTALORDERVALUE => $order->getTotalOrderValue(),
        ];
        $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_ITEM] = [];

        foreach ($order->getItem() as $item) {
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_ITEM][] = [
                ArvatoRssRequestApiConstants::ARVATORSS_API_PRODUCTNUMBER => $item->getProductNumber(),
                ArvatoRssRequestApiConstants::ARVATORSS_API_PRODUCTGROUPID => $item->getProductGroupId(),
                ArvatoRssRequestApiConstants::ARVATORSS_API_UNITPRICE => $item->getUnitPrice(),
                ArvatoRssRequestApiConstants::ARVATORSS_API_UNITCOUNT => $item->getUnitCount(),
            ];
        }

        return $result;
    }
}
