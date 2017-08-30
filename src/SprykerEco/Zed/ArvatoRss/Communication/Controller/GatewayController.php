<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;
use Generated\Shared\Transfer\QuoteTransfer;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacade getFacade()
 */
class GatewayController extends AbstractGatewayController
{

    /**
     * @param Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return QuoteTransfer
     */
    public function performRiskCheckAction(QuoteTransfer $quoteTransfer)
    {
        return $this->getFacade();
    }

}
