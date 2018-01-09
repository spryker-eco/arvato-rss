<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use Generated\Shared\Transfer\OrderMapperTransfer;
use Generated\Shared\Transfer\OrderTransfer;
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
     * @param \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig $config
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
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer
     */
    public function mapOrderToRequestTransfer(OrderTransfer $orderTransfer)
    {
        $requestTransfer = new ArvatoRssStoreOrderRequestTransfer();

        $identification = $this->identificationMapper->map();
        $order = $this->orderMapper->map(
            $this->createOrderMapperTransfer($orderTransfer)
        );
        $order = $this->mapSpecificParameters($orderTransfer, $order);

        $requestTransfer->setIdentification($identification);
        $requestTransfer->setOrder($order);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\ArvatoRssOrderTransfer $order
     *
     * @return \Generated\Shared\Transfer\ArvatoRssOrderTransfer
     */
    protected function mapSpecificParameters(OrderTransfer $orderTransfer, ArvatoRssOrderTransfer $order)
    {
        $payment = $orderTransfer->getPayments()[0];

        $order->setPaymentType(
            $this->config->getPaymentTypeMapping(
                $payment->getPaymentMethod()
            )
        );
        if ($orderTransfer->getCustomer()) {
            $order->setDebitorNumber($orderTransfer->getCustomer()->getCustomerReference());
        }

        return $order;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\OrderMapperTransfer
     */
    protected function createOrderMapperTransfer(OrderTransfer $orderTransfer)
    {
        $transfer = new OrderMapperTransfer();
        $customer = $orderTransfer->getCustomer();
        $transfer->setItems($orderTransfer->getItems());
        $transfer->setTotals($orderTransfer->getTotals());
        $transfer->setOrderReference($orderTransfer->getOrderReference());
        $transfer->setCustomerIsGuest($customer ? $customer->getIsGuest() : true);

        return $transfer;
    }
}
