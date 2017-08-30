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

    protected function convertBillingCustomer($arvatoRssRiskCheckRequestTransfer)
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

    protected function convertOrder($arvatoRssRiskCheckRequestTransfer)
    {

    }
}