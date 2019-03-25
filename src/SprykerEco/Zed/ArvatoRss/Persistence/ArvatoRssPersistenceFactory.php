<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapper;
use SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapperInterface;

/**
 * @method \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig getConfig()
 */
class ArvatoRssPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery
     */
    public function createArvatoRssApiCallLogQuery(): SpyArvatoRssApiCallLogQuery
    {
        return SpyArvatoRssApiCallLogQuery::create();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapperInterface
     */
    public function createArvatoRssPersistenceMapper(): ArvatoRssPersistenceMapperInterface
    {
        return new ArvatoRssPersistenceMapper();
    }
}
