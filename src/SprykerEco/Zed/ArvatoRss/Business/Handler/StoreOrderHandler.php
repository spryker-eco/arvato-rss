<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderResponseMapperInterface;

class StoreOrderHandler implements StoreOrderHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapperInterface
     */
    protected $storeOrderRequestMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderResponseMapperInterface
     */
    protected $storeOrderResponseMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface
     */
    protected $apiAdapter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapperInterface $storeOrderRequestMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderResponseMapperInterface $storeOrderResponseMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface $apiAdapter
     */
    public function __construct(
        StoreOrderRequestMapperInterface $storeOrderRequestMapper,
        StoreOrderResponseMapperInterface $storeOrderResponseMapper,
        ApiAdapterInterface $apiAdapter
    ) {

        $this->storeOrderRequestMapper = $storeOrderRequestMapper;
        $this->storeOrderResponseMapper = $storeOrderResponseMapper;
        $this->apiAdapter = $apiAdapter;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function storeOrder(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = $this->storeOrderRequestMapper->mapQuoteToRequestTransfer($quoteTransfer);
        $responseTransfer = $this->apiAdapter->storeOrder($requestTransfer);
        $quoteTransfer = $this->storeOrderResponseMapper->mapResponseToQuote($responseTransfer, $quoteTransfer);

        return $quoteTransfer;
    }
}
