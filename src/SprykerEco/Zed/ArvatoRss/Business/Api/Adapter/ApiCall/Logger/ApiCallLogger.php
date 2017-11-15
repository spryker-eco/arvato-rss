<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;
use stdClass;

class ApiCallLogger implements ApiCallLoggerInterface
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
        $callLog = new SpyArvatoRssApiCallLog();
        $callLog->setOrderReference($orderReference)
            ->setCallType($type)
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
