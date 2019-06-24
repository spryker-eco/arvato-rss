<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

/**
 * @deprecated Use \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface instead.
 */
interface ArvatoRssQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @api
     *
     * @param string $orderReference
     * @param string $type
     *
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery
     */
    public function queryApiLogByOrderReferenceAndType($orderReference, $type);
}
