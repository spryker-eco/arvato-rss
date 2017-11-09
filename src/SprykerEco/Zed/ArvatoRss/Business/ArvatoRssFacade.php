<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssBusinessFactory getFactory()
 */
class ArvatoRssFacade extends AbstractFacade implements ArvatoRssFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTransfer)
    {
        return $this->getFactory()->createRiskCheckHandler()->performRiskCheck($quoteTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function storeOrder(QuoteTransfer $quoteTransfer)
    {
        return $this->getFactory()->createStoreOrderHandler()->storeOrder($quoteTransfer);
    }
}
