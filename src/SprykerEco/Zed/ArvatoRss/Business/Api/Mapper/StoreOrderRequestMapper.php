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
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

class StoreOrderRequestMapper implements StoreOrderRequestMapperInterface
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
     * @var \SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface $iso3166
     */
    protected $iso3166Converter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $moneyFacade
     * @param \SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface $iso3166Converter
     */
    public function __construct(
        ArvatoRssToMoneyInterface $moneyFacade,
        Iso3166ConverterServiceInterface $iso3166Converter
    ) {

        $this->moneyFacade = $moneyFacade;
        $this->iso3166Converter = $iso3166Converter;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTranfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer
     */
    public function mapOrderToRequestTranfer(OrderTransfer $orderTransfer)
    {
        $requestTransfer = new ArvatoRssStoreOrderRequestTransfer();

        $requestTransfer = $this->mapIdentification($requestTransfer, $orderTransfer);
        $requestTransfer = $this->mapOrder($requestTransfer, $orderTransfer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer
     */
    protected function mapIdentification(
        ArvatoRssStoreOrderRequestTransfer $requestTransfer,
        OrderTransfer $orderTransfer
    ) {
        $identificationTransfer = new ArvatoRssIdentificationRequestTransfer();

        $identificationTransfer->setClientId(
            Config::get(ArvatoRssConstants::ARVATORSS_CLIENTID)
        );
        $identificationTransfer->setAuthorisation(
            Config::get(ArvatoRssConstants::ARVATORSS_AUTHORISATION)
        );
        $requestTransfer->setIdentification($identificationTransfer);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer $requestTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer
     */
    protected function mapOrder(
        ArvatoRssRiskCheckRequestTransfer $requestTransfer,
        OrderTransfer $orderTransfer
    ) {

        $order = new ArvatoRssOrderTransfer();

        $order->setCurrency(Store::getInstance()->getCurrencyIsoCode());
        $order->setGrossTotalBill(
            $this->moneyFacade->convertIntegerToDecimal($orderTransfer->getTotals()->getGrandTotal())
        );
        $order->setTotalOrderValue(
            $this->moneyFacade->convertIntegerToDecimal($orderTransfer->getTotals()->getSubtotal())
        );
        foreach ($orderTransfer->getItems() as $item) {
            $itemTransfer = $this->prepareOrderItem($item);
            $order->addItem($itemTransfer);
        }
        $requestTransfer->setOrder($order);

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
     * @param string $dateOfBirth
     *
     * @return string|null
     */
    protected function prepareDateOfBirth($dateOfBirth)
    {
        return $dateOfBirth ? (new DateTime($dateOfBirth))->format(static::DATE_FORMAT) : null;
    }
}
