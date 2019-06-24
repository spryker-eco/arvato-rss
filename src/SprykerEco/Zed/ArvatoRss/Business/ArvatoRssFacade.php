<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * {@inheritdoc}
     *
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
     * {@inheritdoc}
     *
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

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $communicationToken
     * @param string $orderReference
     *
     * @return void
     */
    public function updateApiLog(string $communicationToken, string $orderReference): void
    {
        $this->getFactory()
            ->createAdapterFactory()
            ->createApiCallLogger()
            ->updateLogWithOrderReference($communicationToken, $orderReference);
    }
}
