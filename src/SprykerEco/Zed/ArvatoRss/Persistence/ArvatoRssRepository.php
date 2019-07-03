<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapper;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssPersistenceFactory getFactory()
 */
class ArvatoRssRepository extends AbstractRepository implements ArvatoRssRepositoryInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer|null
     */
    public function findApiLogByOrderReferenceAndType(string $orderReference, string $type): ?ArvatoRssApiCallLogTransfer
    {
        $arvatoRssApiCallLog = $this->getArvatoRssApiCallLogQuery()
            ->filterByCallType($type)
            ->filterByOrderReference($orderReference)
            ->findOne();

        if ($arvatoRssApiCallLog === null) {
            return null;
        }

        return $this->getMapper()
            ->mapEntityToArvatoRssApiCallLogTransfer($arvatoRssApiCallLog, new ArvatoRssApiCallLogTransfer());
    }

    /**
     * @param string $communicationToken
     * @param string $type
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer|null
     */
    public function findApiLogByCommunicationTokenAndType(string $communicationToken, string $type): ?ArvatoRssApiCallLogTransfer
    {
        $arvatoRssApiCallLog = $this->getArvatoRssApiCallLogQuery()
            ->filterByCallType($type)
            ->filterByCommunicationToken($communicationToken)
            ->findOne();

        if ($arvatoRssApiCallLog === null) {
            return null;
        }

        return $this->getMapper()
            ->mapEntityToArvatoRssApiCallLogTransfer($arvatoRssApiCallLog, new ArvatoRssApiCallLogTransfer());
    }

    /**
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery
     */
    protected function getArvatoRssApiCallLogQuery(): SpyArvatoRssApiCallLogQuery
    {
        return $this->getFactory()->createArvatoRssApiCallLogQuery();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapper
     */
    protected function getMapper(): ArvatoRssPersistenceMapper
    {
        return $this->getFactory()->createArvatoRssPersistenceMapper();
    }
}
