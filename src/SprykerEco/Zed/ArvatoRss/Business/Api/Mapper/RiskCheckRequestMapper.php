<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use DateTime;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterInterface;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

class RiskCheckRequestMapper implements RiskCheckRequestMapperInterface
{

    /**
     * @const int PRODUCT_GROUP_ID
     */
    const PRODUCT_GROUP_ID = 1;

    /**
     * @const string DATE_FORMAT
     */
    const DATE_FORMAT = 'Y-m-d';

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $moneyFacade
     */
    protected $moneyFacade;

    /**
     * @var \SprykerEco\Service\ArvatoRss\Iso3166ConverterInterface $iso3166
     */
    protected $iso3166Converter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $moneyFacade
     * @param \SprykerEco\Service\ArvatoRss\Iso3166ConverterInterface $iso3166Converter
     */
    public function __construct(
        ArvatoRssToMoneyInterface $moneyFacade,
        Iso3166ConverterInterface $iso3166Converter
    ) {

        $this->moneyFacade = $moneyFacade;
        $this->iso3166Converter = $iso3166Converter;
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
    protected function mapIdentification(
        ArvatoRssRiskCheckRequestTransfer $requestTransfer,
        QuoteTransfer $quoteTransfer
    ) {

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
    protected function mapBillingCustomer(
        ArvatoRssRiskCheckRequestTransfer $requestTransfer,
        QuoteTransfer $quoteTransfer
    ) {

        $billingCustomerTransfer = $this->prepareBillingCustomer($quoteTransfer);
        $requestTransfer->setBillingCustomer($billingCustomerTransfer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function mapOrder(
        ArvatoRssRiskCheckRequestTransfer $requestTransfer,
        QuoteTransfer $quoteTransfer
    ) {

        $orderTransfer = new ArvatoRssOrderTransfer();

        $orderTransfer->setCurrency(Store::getInstance()->getCurrencyIsoCode());
        $orderTransfer->setGrossTotalBill(
            $this->moneyFacade->convertIntegerToDecimal($quoteTransfer->getTotals()->getGrandTotal())
        );
        $orderTransfer->setTotalOrderValue(
            $this->moneyFacade->convertIntegerToDecimal($quoteTransfer->getTotals()->getSubtotal())
        );
        foreach ($quoteTransfer->getItems() as $item) {
            $itemTransfer = $this->prepareOrderItem($item);
            $orderTransfer->addItem($itemTransfer);
        }
        $requestTransfer->setOrder($orderTransfer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $item
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderItemTransfer
     */
    protected function prepareOrderItem(ItemTransfer $item)
    {
        $itemTransfer = new ArvatoRssOrderItemTransfer();
        $itemTransfer->setUnitPrice(
            $this->moneyFacade->convertIntegerToDecimal($item->getUnitPrice())
        );
        $itemTransfer->setProductNumber($item->getSku());
        $itemTransfer->setUnitCount($item->getQuantity());
        $itemTransfer->setProductGroupId(static::PRODUCT_GROUP_ID);

        return $itemTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $billingAddress
     *
     * @return \Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer
     */
    protected function prepareAddressTransfer(AddressTransfer $billingAddress)
    {
        $address = new ArvatoRssCustomerAddressTransfer();
        $address->setCountry($this->iso3166Converter->iso2ToNumeric($billingAddress->getIso2Code()));
        $address->setCity($billingAddress->getCity());
        $address->setStreet($billingAddress->getAddress1());
        $address->setStreetNumber($billingAddress->getAddress2());
        $address->setZipCode($billingAddress->getZipCode());

        return $address;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer
     */
    protected function prepareBillingCustomer(QuoteTransfer $quoteTransfer)
    {
        $customer = $quoteTransfer->getCustomer();
        $billingAddress = $quoteTransfer->getBillingAddress();

        $billingCustomerTransfer = new ArvatoRssBillingCustomerTransfer();
        $address = $this->prepareAddressTransfer($billingAddress);
        $billingCustomerTransfer->setAddress($address);
        $billingCustomerTransfer->setFirstName($billingAddress->getFirstName());
        $billingCustomerTransfer->setLastName($billingAddress->getLastName());
        $billingCustomerTransfer->setSalutation(strtoupper($customer->getSalutation()));
        $billingCustomerTransfer->setEmail($customer->getEmail());
        $billingCustomerTransfer->setTelephoneNumber($billingAddress->getPhone());

        $dateOfBirth = $this->prepareDateOfBirth($customer->getDateOfBirth());
        $billingCustomerTransfer->setBirthDay($dateOfBirth);

        return $billingCustomerTransfer;
    }

    /**
     * @param string $dateOfBirth
     *
     * @return string|null
     */
    protected function prepareDateOfBirth($dateOfBirth)
    {
        return $dateOfBirth ? (new DateTime($dateOfBirth))->format(static::DATE_FORMAT) : null;
    }

}
