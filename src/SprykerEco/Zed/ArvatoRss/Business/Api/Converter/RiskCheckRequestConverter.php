<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssApiConstants;

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
            ArvatoRssApiConstants::ARVATORSS_API_COUNTRY => $addressTranfer->getCountry(),
            ArvatoRssApiConstants:: ARVATORSS_API_CITY => $addressTranfer->getCity(),
            ArvatoRssApiConstants::ARVATORSS_API_STREET => $addressTranfer->getStreet(),
            ArvatoRssApiConstants::ARVATORSS_API_STREET_NUMBER => $addressTranfer->getStreetNumber(),
            ArvatoRssApiConstants::ARVATORSS_API_ZIPCODE => $addressTranfer->getZipCode(),
        ];
        $result[ArvatoRssApiConstants::ARVATORSS_API_BILLINGCUSTOMER] = [
            ArvatoRssApiConstants::ARVATORSS_API_FIRSTNAME => $billingCustomerTransfer->getFirstName(),
            ArvatoRssApiConstants::ARVATORSS_API_LASTNAME => $billingCustomerTransfer->getLastName(),
            ArvatoRssApiConstants::ARVATORSS_API_ADDRESS => $address,
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

        $result[ArvatoRssApiConstants::ARVATORSS_API_ORDER] = [
            //TODO: Clarify what it means
            ArvatoRssApiConstants::ARVATORSS_API_REGISTEREDORDER=> true,
            ArvatoRssApiConstants::ARVATORSS_API_CURRENCY => $order->getCurrency(),
            ArvatoRssApiConstants::ARVATORSS_API_GROSSTOTALBILL => $order->getGrossTotalBill(),
            ArvatoRssApiConstants::ARVATORSS_API_TOTALORDERVALUE => $order->getTotalOrderValue(),
        ];
        // TODO: deal with items.
        $result[ArvatoRssApiConstants::ARVATORSS_API_ORDER][ArvatoRssApiConstants::ARVATORSS_API_ITEM] = [];

        foreach ($order->getItem() as $item) {
            $result[ArvatoRssApiConstants::ARVATORSS_API_ORDER][ArvatoRssApiConstants::ARVATORSS_API_ITEM][] = [
                //TODO: clarify this. Is it sku?
                ArvatoRssApiConstants::ARVATORSS_API_PRODUCTNUMBER => $item->getProductNumber(),
                //TODO: clarify
                ArvatoRssApiConstants::ARVATORSS_API_PRODUCTGROUPID => $item->getProductGroupId(),
                ArvatoRssApiConstants::ARVATORSS_API_UNITPRICE => $item->getUnitPrice(),
                ArvatoRssApiConstants::ARVATORSS_API_UNITCOUNT => $item->getUnitCount(),
            ];
        }

        return $result;
    }

}
