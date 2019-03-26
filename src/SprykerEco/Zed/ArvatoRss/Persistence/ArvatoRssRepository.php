<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssPersistenceFactory getFactory()
 */
class ArvatoRssRepository implements ArvatoRssRepositoryInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function findApiLogByOrderReferenceAndType(string $orderReference, string $type): ArvatoRssApiCallLogTransfer
    {
        $arvatoRssApiCallLog = $this->getFactory()->createArvatoRssApiCallLogQuery()
            ->filterByCallType($type)
            ->filterByOrderReference($orderReference)
            ->findOne();

        if ($arvatoRssApiCallLog === null) {
            return new ArvatoRssApiCallLogTransfer();
        }

        return $this->getFactory()
            ->createArvatoRssPersistenceMapper()
            ->mapEntityToArvatoRssApiCallLogTransfer($arvatoRssApiCallLog, new ArvatoRssApiCallLogTransfer());
    }
}
