<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractQueryContainer;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssPersistenceFactory getFactory()
 */
class ArvatoRssQueryContainer extends AbstractQueryContainer implements ArvatoRssQueryContainerInterface
{
    /**
     * @api
     *
     * @param string $orderReference
     * @param string $type
     *
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery
     */
    public function queryApiLogByOrderReferenceAndType($orderReference, $type)
    {
        return $this->getFactory()->createArvatoRssApiCallLogQuery();
    }
}
