<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Reader;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;

interface ArvatoRssReaderInterface
{
    /**
     * @param string $reference
     * @param string $callType
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function getApiLogByOrderReferenceAndType(string $reference, string $callType): ArvatoRssApiCallLogTransfer;
}
