<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence\Mapper;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;

class ArvatoRssPersistenceMapper implements ArvatoRssPersistenceMapperInterface
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
