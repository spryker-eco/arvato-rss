<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer|null
     */
    public function findApiLogByOrderReferenceAndType(string $orderReference, string $type): ?ArvatoRssApiCallLogTransfer
    {
        $arvatoRssApiCallLog = $this->getFactory()->createArvatoRssApiCallLogQuery()
            ->filterByCallType($type)
            ->filterByOrderReference($orderReference)
            ->findOne();

        if ($arvatoRssApiCallLog === null) {
            return null;
        }

        return $this->getFactory()
            ->createArvatoRssPersistenceMapper()
            ->mapEntityToArvatoRssApiCallLogTransfer($arvatoRssApiCallLog, new ArvatoRssApiCallLogTransfer());
    }
}
