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
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterInterface;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

class RiskCheckRequestMapper implements RiskCheckRequestMapperInterface
{

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $money
     */
    protected $money;

    /**
     * @var \SprykerEco\Service\ArvatoRss\Iso3166ConverterInterface $iso3166
     */
    protected $iso3166;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $money
     * @param \SprykerEco\Service\ArvatoRss\Iso3166ConverterInterface $iso3166
     */
    public function __construct(
        ArvatoRssToMoneyInterface $money,
        Iso3166ConverterInterface $iso3166
    ) {

        $this->money = $money;
        $this->iso3166 = $iso3166;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    public function mapQuoteToRequestTranfer(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();

        $requestTransfer = $this->mapIdentification($requestTransfer, $quoteTransfer);
        $requestTransfer = $this->mapBillingCustomer($requestTransfer, $quoteTransfer);
        $requestTransfer = $this->mapOrder($requestTransfer, $quoteTransfer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
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

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function mapBillingCustomer($requestTransfer, $quoteTransfer)
    {
        $billingCustomerTransfer = new ArvatoRssBillingCustomerTransfer();
        $address = new ArvatoRssCustomerAddressTransfer();
        $customer = $quoteTransfer->getCustomer();
        $billingAddress = $quoteTransfer->getBillingAddress();

        $address->setCountry($this->iso3166->iso2ToNumeric($billingAddress->getIso2Code()));
        $address->setCity($billingAddress->getCity());
        $address->setStreet($billingAddress->getAddress1());
        $address->setStreetNumber($billingAddress->getAddress2());
        $address->setZipCode($billingAddress->getZipCode());
        $billingCustomerTransfer->setAddress($address);
        $billingCustomerTransfer->setFirstName($customer->getFirstName());
        $billingCustomerTransfer->setLastName($customer->getLastName());
        $billingCustomerTransfer->setSalutation($customer->getSalutation());
        $billingCustomerTransfer->setEmail($customer->getEmail());
        $billingCustomerTransfer->setTelephoneNumber($customer->getPhone());
        $billingCustomerTransfer->setBirthDay($customer->getDateOfBirth());

        $requestTransfer->setBillingCustomer($billingCustomerTransfer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function mapOrder($requestTransfer, $quoteTransfer)
    {
        $orderTransfer = new ArvatoRssOrderTransfer();

        $orderTransfer->setCurrency(Store::getInstance()->getCurrencyIsoCode());
        $orderTransfer->setGrossTotalBill(
            $this->money->convertIntegerToDecimal($quoteTransfer->getTotals()->getGrandTotal())
        );
        $orderTransfer->setTotalOrderValue(
            $this->money->convertIntegerToDecimal($quoteTransfer->getTotals()->getGrandTotal())
        );
        foreach ($quoteTransfer->getItems() as $item) {
            $itemTransfer = new ArvatoRssOrderItemTransfer();
            $itemTransfer->setUnitPrice(
                $this->money->convertIntegerToDecimal($item->getUnitPrice())
            );
            $itemTransfer->setProductNumber($item->getSku());
            $itemTransfer->setUnitCount($item->getQuantity());
            $itemTransfer->setProductGroupId(1);
            $orderTransfer->addItem($itemTransfer);
        }

        $requestTransfer->setOrder($orderTransfer);

        return $requestTransfer;
    }

}
