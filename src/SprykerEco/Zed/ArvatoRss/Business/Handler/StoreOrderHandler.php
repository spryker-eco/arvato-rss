<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
