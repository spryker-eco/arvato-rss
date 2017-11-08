<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use Generated\Shared\Transfer\OrderTransfer;

interface StoreOrderResponseMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer $arvatoRssStoreOrderResponseTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function mapResponseToOrder(
        ArvatoRssStoreOrderResponseTransfer $arvatoRssStoreOrderResponseTransfer,
        OrderTransfer $orderTransfer
    );
}
