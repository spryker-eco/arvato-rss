<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence\Mapper;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;

interface ArvatoRssPersistenceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     * @param \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog
     *
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog
     */
    public function mapArvatoRssApiCallLogTransferToEntity(
        ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer,
        SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog
    ): SpyArvatoRssApiCallLog;

    /**
     * @param \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function mapEntityToArvatoRssApiCallLogTransfer(
        SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog,
        ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
    ): ArvatoRssApiCallLogTransfer;
}
