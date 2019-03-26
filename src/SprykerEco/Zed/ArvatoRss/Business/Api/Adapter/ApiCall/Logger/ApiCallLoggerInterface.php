<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
