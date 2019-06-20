<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;
use stdClass;

class ApiCallLogger implements ApiCallLoggerInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     * @param string $resultCode
     * @param array $requestPayload
     * @param \stdClass $responsePayload
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
