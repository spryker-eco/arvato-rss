<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;

interface ApiCallInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     * @param array $params
     *
     * @return \stdClass
     */
    public function execute(
        ArvatoRssIdentificationRequestTransfer $identification,
        array $params
    );
}
