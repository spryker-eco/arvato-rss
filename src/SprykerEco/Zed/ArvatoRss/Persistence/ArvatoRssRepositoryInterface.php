<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;

interface ArvatoRssRepositoryInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer|null
     */
    public function findApiLogByOrderReferenceAndType(string $orderReference, string $type): ?ArvatoRssApiCallLogTransfer;
}
