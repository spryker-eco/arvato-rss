<?php

namespace SprykerEco\Zed\ArvatoRss\Persistence\Mapper;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;

interface ArvatoRssPersistenceMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     * @param \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog
     *
     * @return SpyArvatoRssApiCallLog
     */
    public function mapArvatoRssApiCallLogTransferToEntity(
        ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer,
        SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog
    ): SpyArvatoRssApiCallLog;

    /**
     * @param \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     *
     * @return ArvatoRssApiCallLogTransfer
     */
    public function mapEntityToArvatoRssApiCallLogTransfer(
        SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog,
        ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
    ): ArvatoRssApiCallLogTransfer;
}
