<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Spryker\Zed\Kernel\Persistence\QueryContainer\QueryContainerInterface;

interface ArvatoRssQueryContainerInterface extends QueryContainerInterface
{
    /**
     * @api
     *
     * @param string $orderReference
     * @param string $type
     *
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssTransactionLogQuery
     */
    public function queryTransactionByOrderReferenceAndType($orderReference, $type);
}