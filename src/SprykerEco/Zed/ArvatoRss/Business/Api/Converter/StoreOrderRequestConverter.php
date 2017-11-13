<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConstants;

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

        $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER] = [
            ArvatoRssRequestApiConstants::ARVATORSS_API_REGISTEREDORDER => $order->getRegisteredOrder(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER_NUMBER => $order->getOrderNumber(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_DEBITOR_NUMBER => $order->getDebitorNumber(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_PAYMENT_TYPE => $order->getPaymentType(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_CURRENCY => $order->getCurrency(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_GROSSTOTALBILL => $order->getGrossTotalBill(),
            ArvatoRssRequestApiConstants::ARVATORSS_API_TOTALORDERVALUE => $order->getTotalOrderValue(),
        ];
        $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_ITEM] = [];

        foreach ($order->getItems() as $item) {
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
