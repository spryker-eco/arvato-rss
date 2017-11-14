<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssTransactionLog;
use stdClass;

class TransactionLogger implements TransactionLoggerInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     * @param string $resultCode
     * @param string $requestPayload
     * @param string $responsePayload
     *
     * @return void
     */
    public function log(
        $orderReference,
        $type,
        $resultCode,
        array $requestPayload,
        stdClass $responsePayload
    ) {
        $transactionLog = new SpyArvatoRssTransactionLog();
        $transactionLog->setOrderReference($orderReference)
            ->setTransactionType($type)
            ->setResultCode($resultCode)
            ->setRequestPayload(
                print_r($requestPayload, true)
            )
            ->setResponsePayload(
                print_r($responsePayload, true)
            )
            ->save();
    }
}
