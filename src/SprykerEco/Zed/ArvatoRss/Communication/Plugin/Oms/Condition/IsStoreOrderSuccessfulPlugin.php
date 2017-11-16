<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Communication\Plugin\Oms\Condition;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;
use Orm\Zed\Sales\Persistence\SpySalesOrderItem;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Dependency\Plugin\Condition\ConditionInterface;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Business\ArvatorssFacadeInterface getFacade()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssQueryContainerInterface getQueryContainer()
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
        $storeOrderApiCallLog = $this->getApiCallLogEntry($orderReference);
        if ($storeOrderApiCallLog === null) {
            return false;
        }

        return $this->isTransactionSuccessfull($storeOrderApiCallLog);
    }

    /**
     * @param string $orderReference
     *
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog
     */
    protected function getApiCallLogEntry($orderReference)
    {
        return $this->getQueryContainer()
            ->queryApiLogByOrderReferenceAndType(
                $orderReference,
                ArvatoRssApiConfig::TRANSACTION_TYPE_STORE_ORDER
            )
            ->findOne();
    }

    /**
     * @param \Orm\Zed\ArvatoRss\Persistence\Base\SpyArvatoRssApiCallLog $apiCallLog
     *
     * @return bool
     */
    protected function isTransactionSuccessfull(SpyArvatoRssApiCallLog $apiCallLog)
    {
        return $apiCallLog->getResultCode() == ArvatoRssApiConfig::RESULT_CODE_SUCCESS;
    }
}
