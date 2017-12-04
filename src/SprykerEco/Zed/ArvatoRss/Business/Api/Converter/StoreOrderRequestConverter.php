<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConfig;

class StoreOrderRequestConverter implements StoreOrderRequestConverterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer $arvatoRssStoreOrderRequestTransfer
     *
     * @return array
     */
    public function convert(ArvatoRssStoreOrderRequestTransfer $arvatoRssStoreOrderRequestTransfer)
    {
        return $this->convertOrder($arvatoRssStoreOrderRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer $arvatoRssStoreOrderRequestTransfer
     *
     * @return array
     */
    protected function convertOrder(ArvatoRssStoreOrderRequestTransfer $arvatoRssStoreOrderRequestTransfer)
    {
        $result = [];
        $order = $arvatoRssStoreOrderRequestTransfer->getOrder();

        $result[ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER] = [
            ArvatoRssRequestApiConfig::ARVATORSS_API_REGISTEREDORDER => $order->getRegisteredOrder(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER_NUMBER => $order->getOrderNumber(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_DEBITOR_NUMBER => $order->getDebitorNumber(),
            ArvatoRssRequestApiConfig::ARVATORSS_API_PAYMENT_TYPE => $order->getPaymentType(),
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
