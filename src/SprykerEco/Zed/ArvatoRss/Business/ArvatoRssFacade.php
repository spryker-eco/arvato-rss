<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business;

use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssBusinessFactory getFactory()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface getRepository()
 */
class ArvatoRssFacade extends AbstractFacade implements ArvatoRssFacadeInterface
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTransfer)
    {
        return $this->getFactory()->createRiskCheckHandler()->performRiskCheck($quoteTransfer);
    }

    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function storeOrder(OrderTransfer $orderTransfer)
    {
        $this->getFactory()->createStoreOrderHandler()->storeOrder($orderTransfer);
    }
}
