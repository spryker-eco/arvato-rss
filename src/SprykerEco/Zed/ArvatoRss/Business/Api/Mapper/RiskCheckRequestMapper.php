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
use Spryker\Shared\Kernel\Store;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

class RiskCheckRequestMapper implements RiskCheckRequestMapperInterface
{

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $money
     */
    protected $money;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $money
     */
    public function __construct(ArvatoRssToMoneyInterface $money)
    {
        $this->money = $money;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    public function mapQuoteToRequestTranfer(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();

        $this->hydrateRequestWithIdentificationData($requestTransfer, $quoteTransfer);
        $this->hydrateRequestWithCustomerData($requestTransfer, $quoteTransfer);
        $this->hydrateRequestWithOrderData($requestTransfer, $quoteTransfer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function hydrateRequestWithIdentificationData($requestTransfer, $quoteTransfer)
    {
        $identification = new ArvatoRssIdentificationRequestTransfer();

        $identification->setClientID(
            Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_CLIENTID]
        );
        $identification->setAuthorisation(
            Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_PASSWORD]
        );
        $requestTransfer->setIdentification($identification);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function hydrateRequestWithCustomerData($requestTransfer, $quoteTransfer)
    {
        $billingCustomer = new ArvatoRssBillingCustomerTransfer();
        $address = new ArvatoRssCustomerAddressTransfer();
        $customer = $quoteTransfer->getCustomer();
        $billingAddress = $quoteTransfer->getBillingAddress();

        $address->setCountry($billingAddress->getIso2Code());
        $address->setCity($billingAddress->getCity());
        $address->setStreet($billingAddress->getAddress1());
        $address->setZipCode($billingAddress->getZipCode());
        $billingCustomer->setAddress($address);

        $billingCustomer->setFirstName($customer->getFirstName());
        $billingCustomer->setLastName($customer->getLastName());
        $billingCustomer->setSalutation($customer->getSalutation());
        $billingCustomer->setEmail($customer->getEmail());
        $billingCustomer->setTelephoneNumber($customer->getPhone());
        $billingCustomer->setBirthDay($customer->getDateOfBirth());
        $requestTransfer->setBillingCustomer($billingCustomer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function hydrateRequestWithOrderData($requestTransfer, $quoteTransfer)
    {
        $order = new ArvatoRssOrderTransfer();
        $customer = $quoteTransfer->getCustomer();

        $order->setCurrency(Store::getInstance()->getCurrencyIsoCode());
        $order->setRegisteredOrder(!$customer->getIsGuest());
        $order->setGrossTotalBill(
            $this->money->convertIntegerToDecimal($quoteTransfer->getTotals()->getGrandTotal())
        );
        $order->setTotalOrderValue(
            $this->money->convertIntegerToDecimal($quoteTransfer->getTotals()->getGrandTotal())
        );

        //TODO: clarify what position means and fix if needed.
        $position = 1;
        foreach ($quoteTransfer->getItems() as $item) {
            $itemTransfer = new ArvatoRssOrderItemTransfer();
            $itemTransfer->setPosition($position++);
            $itemTransfer->setProductNumber($item->getSku());
            $itemTransfer->setUnitPrice($item->getUnitGrossPrice());
            $itemTransfer->setUnitCount(1);
            $order->addItem($itemTransfer);
        }
        $requestTransfer->setOrder($order);

        return $requestTransfer;
    }

}
