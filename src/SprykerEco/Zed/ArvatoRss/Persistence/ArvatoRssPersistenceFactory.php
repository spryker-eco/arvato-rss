<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapper;
use SprykerEco\Zed\ArvatoRss\Persistence\Mapper\ArvatoRssPersistenceMapperInterface;

/**
 * @method \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig getConfig()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface getRepository()
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
