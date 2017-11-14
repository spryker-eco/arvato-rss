<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssPersistenceFactory getFactory
 */
class ArvatoRssQueryContainer extends AbstractQueryContainer implements ArvatoRssQueryContainerInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     *
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssTransactionLogQuery
     */
    public function queryTransactionByOrderReferenceAndType($orderReference, $type)
    {
        return $this->getFactory()->createArvatoRssTransactionLogQuery();
    }
}