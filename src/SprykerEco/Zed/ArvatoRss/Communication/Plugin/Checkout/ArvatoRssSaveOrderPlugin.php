<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Communication\Plugin\Checkout;

use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\SaveOrderTransfer;
use Spryker\Zed\CheckoutExtension\Dependency\Plugin\CheckoutDoSaveOrderInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacadeInterface getFacade()
 * @method \SprykerEco\Zed\ArvatoRss\Communication\ArvatoRssCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig getConfig()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssQueryContainerInterface getQueryContainer()
 */
class ArvatoRssSaveOrderPlugin extends AbstractPlugin implements CheckoutDoSaveOrderInterface
{
    /**
     * Specification:
     * - Updates API log with order reference.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\SaveOrderTransfer $saveOrderTransfer
     *
     * @return void
     */
    public function saveOrder(QuoteTransfer $quoteTransfer, SaveOrderTransfer $saveOrderTransfer)
    {
        $communicationToken = $quoteTransfer->getArvatoRssQuoteData()
            ->getArvatoRssRiskCheckResponse()
            ->getCommunicationToken();

        $this->getFacade()
            ->updateApiLogWithOrderReference($communicationToken, $saveOrderTransfer->getOrderReference());
    }
}
