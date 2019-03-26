<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Handler;

use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapperInterface;

class StoreOrderHandler implements StoreOrderHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapperInterface
     */
    protected $storeOrderRequestMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface
     */
    protected $apiAdapter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapperInterface $storeOrderRequestMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface $apiAdapter
     */
    public function __construct(
        StoreOrderRequestMapperInterface $storeOrderRequestMapper,
        ApiAdapterInterface $apiAdapter
    ) {

        $this->storeOrderRequestMapper = $storeOrderRequestMapper;
        $this->apiAdapter = $apiAdapter;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function storeOrder(OrderTransfer $orderTransfer)
    {
        $requestTransfer = $this->storeOrderRequestMapper->mapOrderToRequestTransfer($orderTransfer);
        $this->apiAdapter->storeOrder($requestTransfer);
    }
}
