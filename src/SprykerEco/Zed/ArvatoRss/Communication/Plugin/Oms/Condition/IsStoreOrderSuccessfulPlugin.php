<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Communication\Plugin\Oms\Condition;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Business\ArvatorssFacadeInterface getFacade()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface getRepository()
 * @method \SprykerEco\Zed\ArvatoRss\Communication\ArvatoRssCommunicationFactory getFactory()
 * @method \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig getConfig()
 */
class IsStoreOrderSuccessfulPlugin extends AbstractPlugin implements ConditionInterface
{
    /**
     * @api
     *
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrderItem $orderItem
     *
     * @return bool
     */
    public function check(SpySalesOrderItem $orderItem): bool
    {
        return $this->isStoreOrderSuccessful(
            $orderItem
                ->getOrder()
                ->getOrderReference()
        );
    }

    /**
     * @param string $orderReference
     *
     * @return bool
     */
    protected function isStoreOrderSuccessful(string $orderReference): bool
    {
        $storeOrderApiCallLogTransfer = $this->getApiCallLogEntry($orderReference);

        if ($storeOrderApiCallLogTransfer === null) {
            return false;
        }

        return $this->isTransactionSuccessful($storeOrderApiCallLogTransfer);
    }

    /**
     * @param string $orderReference
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer|null
     */
    protected function getApiCallLogEntry(string $orderReference): ?ArvatoRssApiCallLogTransfer
    {
        return $this->getRepository()
            ->findApiLogByOrderReferenceAndType(
                $orderReference,
                ArvatoRssApiConfig::TRANSACTION_TYPE_STORE_ORDER
            );
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     *
     * @return bool
     */
    protected function isTransactionSuccessful(ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer)
    {
        return $arvatoRssApiCallLogTransfer->getResultCode() == ArvatoRssApiConfig::RESULT_CODE_SUCCESS;
    }
}
