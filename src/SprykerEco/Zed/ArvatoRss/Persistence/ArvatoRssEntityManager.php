<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;
use SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapper;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssPersistenceFactory getFactory()
 */
class ArvatoRssEntityManager extends AbstractEntityManager implements ArvatoRssEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function saveArvatoRssApiLogEntity(ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer): ArvatoRssApiCallLogTransfer
    {
        $arvatoRssApiCallLogEntity = new SpyArvatoRssApiCallLog();

        $arvatoRssApiCallLogEntity->fromArray(
            $arvatoRssApiCallLogTransfer->modifiedToArray()
        );

        $arvatoRssApiCallLogEntity->save();

        return $this->getMapper()
            ->mapEntityToArvatoRssApiCallLogTransfer(
                $arvatoRssApiCallLogEntity,
                $arvatoRssApiCallLogTransfer
            );
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function updateArvatoRssApiLogEntity(ArvatoRssApiCallLogTransfer $arvatoRssApiCallLogTransfer): ArvatoRssApiCallLogTransfer
    {
        $arvatoRssApiCallLogEntity = $this->getFactory()
            ->createArvatoRssApiCallLogQuery()
            ->filterByCommunicationToken($arvatoRssApiCallLogTransfer->getCommunicationToken())
            ->filterByCallType($arvatoRssApiCallLogTransfer->getCallType())
            ->findOneOrCreate();

        $arvatoRssApiCallLogEntity->fromArray(
            $arvatoRssApiCallLogTransfer->modifiedToArray()
        );

        $arvatoRssApiCallLogEntity->save();

        return $this->getMapper()
            ->mapEntityToArvatoRssApiCallLogTransfer(
                $arvatoRssApiCallLogEntity,
                $arvatoRssApiCallLogTransfer
            );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapper
     */
    protected function getMapper(): ArvatoRssPersistenceMapper
    {
        return $this->getFactory()->createArvatoRssPersistenceMapper();
    }
}
