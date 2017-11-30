<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Handler;

use Generated\Shared\Transfer\OrderTransfer;

interface StoreOrderHandlerInterface
{
    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function storeOrder(OrderTransfer $orderTransfer);
}
