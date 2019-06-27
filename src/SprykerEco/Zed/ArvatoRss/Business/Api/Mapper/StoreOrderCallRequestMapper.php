<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use Generated\Shared\Transfer\OrderMapperTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Zed\ArvatoRss\ArvatoRssConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Reader\ArvatoRssReaderInterface;
use SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface;

class StoreOrderCallRequestMapper implements StoreOrderRequestMapperInterface
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
     * @var \SprykerEco\Zed\ArvatoRss\Business\Reader\ArvatoRssReaderInterface
     */
    protected $reader;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig $config
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface $identificationMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface $orderMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Reader\ArvatoRssReaderInterface $reader
     * @param \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig $config
     */
    public function __construct(
        IdentificationMapperInterface $identificationMapper,
        OrderMapperInterface $orderMapper,
        ArvatoRssReaderInterface $reader,
        ArvatoRssConfig $config
    ) {
        $this->identificationMapper = $identificationMapper;
        $this->orderMapper = $orderMapper;
        $this->reader = $reader;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer
     */
    public function mapOrderToRequestTransfer(OrderTransfer $orderTransfer): ArvatoRssStoreOrderRequestTransfer
    {
        $requestTransfer = new ArvatoRssStoreOrderRequestTransfer();

        $identification = $this->identificationMapper->map();
        $identification = $this->updateIdentification($orderTransfer, $identification);

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
    protected function mapSpecificParameters(OrderTransfer $orderTransfer, ArvatoRssOrderTransfer $order): ArvatoRssOrderTransfer
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
    protected function createOrderMapperTransfer(OrderTransfer $orderTransfer): OrderMapperTransfer
    {
        $orderMapperTransfer = new OrderMapperTransfer();
        $orderMapperTransfer->fromArray(
            $orderTransfer->toArray(true),
            true
        );
        $customer = $orderTransfer->getCustomer();
        $orderMapperTransfer->setCustomerIsGuest($customer ? $customer->getIsGuest() : true);

        return $orderMapperTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     *
     * @return \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer
     */
    protected function updateIdentification(
        OrderTransfer $orderTransfer,
        ArvatoRssIdentificationRequestTransfer $identification
    ): ArvatoRssIdentificationRequestTransfer {
        $arvatoRssApiCallLogTransfer = $this->reader
            ->getApiLogByOrderReferenceAndType(
                $orderTransfer->getOrderReference(),
                ArvatoRssApiConfig::TRANSACTION_TYPE_RISK_CHECK
            );

        $identification->setCommunicationToken($arvatoRssApiCallLogTransfer->getCommunicationToken());

        return $identification;
    }
}
