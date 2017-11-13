<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\ArvatoRss\ArvatoRssConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface;

class StoreOrderRequestMapper implements StoreOrderRequestMapperInterface
{
    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface
     */
    protected $identificationMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface
     */
    protected $orderMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig $config
     */
    protected $config;
    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface $identificationMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface $orderMapper
     */
    public function __construct(
        IdentificationMapperInterface $identificationMapper,
        OrderMapperInterface $orderMapper,
        ArvatoRssConfig $config
    ) {
        $this->identificationMapper = $identificationMapper;
        $this->orderMapper = $orderMapper;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer
     */
    public function mapQuoteToRequestTransfer(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = new ArvatoRssStoreOrderRequestTransfer();

        $identification = $this->identificationMapper->map();
        $order = $this->orderMapper->map($quoteTransfer);

        $requestTransfer->setIdentification($identification);
        $requestTransfer->setOrder($order);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\ArvatoRssOrderTransfer $order
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderTransfer
     */
    protected function mapSpecificParameters(QuoteTransfer $quoteTransfer, ArvatoRssOrderTransfer $order)
    {
        $order->setPaymentType(
            $this->config->getPaymentTypeMapping(
                $quoteTransfer->getPayment()->getPaymentMethod()
            )
        );

        $order->setDebitorNumber($quoteTransfer->getCustomer()->getIdCustomer());

        return $order;
    }
}
