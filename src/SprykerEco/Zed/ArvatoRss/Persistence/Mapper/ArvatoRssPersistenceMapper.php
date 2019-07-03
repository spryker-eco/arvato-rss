<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence\Mapper;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;

class ArvatoRssPersistenceMapper
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     * @param \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog
     *
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog
     */
    public function mapArvatoRssApiCallLogTransferToEntity(ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer, SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog): SpyArvatoRssApiCallLog
    {
        $spyArvatoRssApiCallLog->fromArray($arvatoRssApiCallLogTransfer->modifiedToArray());
        $spyArvatoRssApiCallLog->setNew($arvatoRssApiCallLogTransfer->getIdPaymentArvatoRssApiCallLog() === null);

        return $spyArvatoRssApiCallLog;
    }

    /**
     * @param \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function mapEntityToArvatoRssApiCallLogTransfer(SpyArvatoRssApiCallLog $spyArvatoRssApiCallLog, ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer): ArvatoRssApiCallLogTransfer
    {
        return $arvatoRssApiCallLogTransfer->fromArray($spyArvatoRssApiCallLog->toArray(), true);
    }
}
