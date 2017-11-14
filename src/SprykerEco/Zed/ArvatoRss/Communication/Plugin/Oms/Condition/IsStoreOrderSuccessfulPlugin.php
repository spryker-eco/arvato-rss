<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */


namespace SprykerEco\Zed\ArvatoRss\Communication\Plugin\Oms\Command;

use Orm\Zed\ArvatoRss\Persistence\Base\SpyArvatoRssTransactionLog;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConstants;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Business\ArvatorssFacade getFacade()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssQueryContainer getQueryContainer()
 * @method \SprykerEco\Zed\ArvatoRss\Communication\ArvatoRssCommunicationFactory getFactory()
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
    public function check(SpySalesOrderItem $orderItem)
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
    protected function isStoreOrderSuccessful($orderReference)
    {
        $storeOrderTrasactionLog = $this->getTransactionLogEntry($orderReference);
        if ($storeOrderTrasactionLog === null) {
            return false;
        }

        return $this->isTransactionSuccessfull($storeOrderTrasactionLog);
    }

    /**
     * @param string $orderReference
     *
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssTransactionLog
     */
    protected function getTransactionLogEntry($orderReference)
    {
        return $this->getQueryContainer()
            ->queryTransactionByOrderReferenceAndType(
                $orderReference,
                ArvatoRssApiConstants::TRANSACTION_TYPE_STORE_ORDER
            )
            ->findOne();
    }

    /**
     * @param \Orm\Zed\ArvatoRss\Persistence\Base\SpyArvatoRssTransactionLog $transactionLog
     *
     * @return bool
     */
    protected function isTransactionSuccessfull(SpyArvatoRssTransactionLog $transactionLog)
    {
        return $transactionLog->getResultCode() == ArvatoRssApiConstants::RESULT_CODE_SUCCESS;
    }
}