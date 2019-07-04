<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;

interface ArvatoRssEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function saveArvatoRssApiLogEntity(ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer): ArvatoRssApiCallLogTransfer;

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function updateArvatoRssApiLogEntity(ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer): ArvatoRssApiCallLogTransfer;
}
