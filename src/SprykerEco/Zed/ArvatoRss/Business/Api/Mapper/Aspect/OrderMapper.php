<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

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
     * @param \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $moneyFacade
     */
    public function __construct(
        ArvatoRssToMoneyInterface $moneyFacade
    ) {
        $this->moneyFacade = $moneyFacade;
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderTransfer
     */
    public function map(QuoteTransfer $quoteTransfer)
    {
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
}