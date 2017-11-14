<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger;

interface TransactionLoggerInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     * @param string $result
     * @param string $requestPayload
     * @param string $responsePayload
     *
     * @return void
     */
    public function log(
        $orderReference,
        $type,
        $result,
        array $requestPayload,
        \stdClass $responsePayload
    );
}