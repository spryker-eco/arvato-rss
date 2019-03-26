<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
