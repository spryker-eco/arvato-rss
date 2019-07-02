<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger;

use stdClass;

interface ApiCallLoggerInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     * @param string $result
     * @param array $requestPayload
     * @param \stdClass $responsePayload
     *
     * @return void
     */
    public function log(
        $orderReference,
        $type,
        $result,
        array $requestPayload,
        stdClass $responsePayload
    );
}
