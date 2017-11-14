<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssTransactionLogQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

class ArvatoRssPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssTransactionLogQuery
     */
    public function createArvatoRssTransactionLogQuery()
    {
        return SpyArvatoRssTransactionLogQuery::create()->orderByUpdatedAt(Criteria::DESC);
    }
}