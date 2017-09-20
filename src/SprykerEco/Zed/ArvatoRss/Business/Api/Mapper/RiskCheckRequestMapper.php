<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;

class RiskCheckRequestMapper implements RiskCheckRequestMapperInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    public function mapQuoteToRequestTranfer(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();

        $this->mapIdentification($requestTransfer, $quoteTransfer);
        $this->mapBillingCustomer($requestTransfer, $quoteTransfer);
        $this->mapOrder($requestTransfer, $quoteTransfer);

        return $requestTransfer;
    }


    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function mapIdentification($requestTransfer, $quoteTransfer)
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();
        $identificationTransfer = new ArvatoRssIdentificationRequestTransfer();

        $identificationTransfer->setClientId(
            Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_CLIENTID]
        );
        $identificationTransfer->setAuthorisation(
            Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_PASSWORD]
        );
        $requestTransfer->setIdentification($identificationTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function mapBillingCustomer($requestTransfer, $quoteTransfer)
    {
        $billingCustomerTransfer = new ArvatoRssBillingCustomerTransfer();
        $address = new ArvatoRssCustomerAddressTransfer();
        $customer = $quoteTransfer->getCustomer();
        $customerAddress = $customer->getDefaultBillingAddress();

        $address->setCountry($customerAddress->getCountry());
        $address->setCity($customerAddress->getCity());
        $address->setStreet($customerAddress->getAddress1());
        $address->setZipCode($customerAddress->getZipCode());
        $billingCustomerTransfer->setAddress($address);
        $billingCustomerTransfer->setFirstName($customer->getFirstName());
        $billingCustomerTransfer->setLastName($customer->getLastName());
        $billingCustomerTransfer->setSalutation($customer->getSalutation());
        $billingCustomerTransfer->setEmail($customer->getEmail());
        $billingCustomerTransfer->setTelephoneNumber($customer->getPhone());
        $billingCustomerTransfer->setBirthDay($customer->getDateOfBirth());

        $requestTransfer->setBillingCustomer($billingCustomerTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function mapOrder($requestTransfer, $quoteTransfer)
    {
        $orderTransfer = new ArvatoRssOrderTransfer();
        $itemTransfer = new ArvatoRssOrderItemTransfer();

        foreach ($quoteTransfer->getItems() as $item) {
            $itemTransfer->setPosition(1);
            $itemTransfer->setUnitPrice($item->getUnitPrice());
            $itemTransfer->setProductNumber($item->getProductConcrete()->getSku());
            $itemTransfer->setUnitCount($item->getQuantity());
            $orderTransfer->addItem($itemTransfer);
        }

        $requestTransfer->setOrder($orderTransfer);
    }

}