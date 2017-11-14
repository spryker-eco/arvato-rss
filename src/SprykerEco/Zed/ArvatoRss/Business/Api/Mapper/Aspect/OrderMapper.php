<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToStoreInterface;

class OrderMapper implements OrderMapperInterface
{
    /**
     * @const int PRODUCT_GROUP_ID
     */
    const PRODUCT_GROUP_ID = 1;

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
     * @param \Generated\Shared\Transfer\TotalsTransfer $totalsTransfer
     * @param array|\ArrayObject $items
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderTransfer
     */
    public function map(TotalsTransfer $totalsTransfer, $items, $orderReference)
    {
        $order = new ArvatoRssOrderTransfer();

        $order->setCurrency(
            $this->storeFacade
                ->getCurrentStore()
                ->getSelectedCurrencyIsoCode()
        );
        $order->setRegisteredOrder(true);
        $order->setGrossTotalBill(
            $this->moneyFacade->convertIntegerToDecimal($totalsTransfer->getGrandTotal())
        );
        $order->setOrderNumber($orderReference);
        $order->setTotalOrderValue(
            $this->moneyFacade->convertIntegerToDecimal($totalsTransfer->getSubtotal())
        );
        foreach ($items as $itemTransfer) {
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
