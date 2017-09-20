<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;

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
        $requestTransfer = $this->mapCustomerData($requestTransfer, $quoteTransfer);
        $requestTransfer = $this->mapOrderDetails($requestTransfer, $quoteTransfer);
        $requestTransfer = $this->mapCartDetails($requestTransfer, $quoteTransfer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function mapCustomerData(
        ArvatoRssRiskCheckRequestTransfer $requestTransfer,
        QuoteTransfer $quoteTransfer
    )
    {
        $customer = $quoteTransfer->getCustomer();
        $shippingAddress = $customer->getShippingAddress();

        $requestTransfer->setFirstName($customer->getFirstName());
        $requestTransfer->setLastName($customer->getLastName());
        $requestTransfer->setStreet($shippingAddress->getAddress1());
        $requestTransfer->setZipCode($shippingAddress->getZipCode());
        $requestTransfer->setCity($shippingAddress->getCity());
        $requestTransfer->setCountry($shippingAddress->getCountry());

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function mapOrderDetails(
        ArvatoRssRiskCheckRequestTransfer $requestTransfer,
        QuoteTransfer $quoteTransfer
    )
    {
        $customer = $quoteTransfer->getCustomer();
        //TODO: check if currency is in allowed list.
        $requestTransfer->setCurrency(
            Store::getInstance()->getCurrencyIsoCode()
        );
        $requestTransfer->setRegisteredOrder(!$customer->isGuest());

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function mapCartDetails(
        ArvatoRssRiskCheckRequestTransfer $requestTransfer,
        QuoteTransfer $quoteTransfer
    )
    {
        //TODO: replace with money converter service.
        $requestTransfer->setGrossTotalBill($quoteTransfer->getTotals()->getGrandTotal() / 100);
        $requestTransfer->setUnitCount(count($quoteTransfer->getItems()));
        //TODO: calculate units price.

        return $requestTransfer;
    }

}