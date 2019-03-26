<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderMapperTransfer;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToStoreInterface;

class OrderMapper implements OrderMapperInterface
{
    /**
     * @const int PRODUCT_GROUP_ID
     */
    public const PRODUCT_GROUP_ID = 1;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface
     */
    protected $moneyFacade;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToStoreInterface
     */
    protected $storeFacade;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $moneyFacade
     * @param \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToStoreInterface $storeFacade
     */
    public function __construct(
        ArvatoRssToMoneyInterface $moneyFacade,
        ArvatoRssToStoreInterface $storeFacade
    ) {
        $this->moneyFacade = $moneyFacade;
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderMapperTransfer $orderMapperTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderTransfer
     */
    public function map(OrderMapperTransfer $orderMapperTransfer)
    {
        $order = new ArvatoRssOrderTransfer();

        $order->setCurrency(
            $this->storeFacade
                ->getCurrentStore()
                ->getSelectedCurrencyIsoCode()
        );
        $order->setRegisteredOrder(!$orderMapperTransfer->getCustomerIsGuest());
        $order->setGrossTotalBill(
            $this->moneyFacade->convertIntegerToDecimal(
                $orderMapperTransfer
                    ->getTotals()
                    ->getGrandTotal()
            )
        );
        $order->setOrderNumber(
            $orderMapperTransfer->getOrderReference()
        );
        $order->setTotalOrderValue(
            $this->moneyFacade->convertIntegerToDecimal(
                $orderMapperTransfer
                    ->getTotals()
                    ->getSubtotal()
            )
        );
        foreach ($orderMapperTransfer->getItems() as $itemTransfer) {
            $item = $this->prepareOrderItem($itemTransfer);
            $order->addItem($item);
        }

        return $order;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderItemTransfer
     */
    protected function prepareOrderItem(ItemTransfer $itemTransfer)
    {
        $item = new ArvatoRssOrderItemTransfer();
        $item->setUnitPrice(
            $this->moneyFacade->convertIntegerToDecimal($itemTransfer->getUnitPrice())
        );
        $item->setProductNumber($itemTransfer->getSku());
        $item->setUnitCount($itemTransfer->getQuantity());
        $item->setProductGroupId(static::PRODUCT_GROUP_ID);

        return $item;
    }
}
