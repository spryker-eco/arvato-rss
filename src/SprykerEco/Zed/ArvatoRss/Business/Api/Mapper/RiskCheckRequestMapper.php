<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\BillingCustomerMapperTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\OrderMapperTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Yves\Ide\Quote;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface;

class RiskCheckRequestMapper implements RiskCheckRequestMapperInterface
{
    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface
     */
    protected $identificationMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface
     */
    protected $billingCustomerMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface
     */
    protected $orderMapper;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface $identificationMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface $billingCustomerMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface $orderMapper
     */
    public function __construct(
        IdentificationMapperInterface $identificationMapper,
        BillingCustomerMapperInterface $billingCustomerMapper,
        OrderMapperInterface $orderMapper
    ) {
        $this->identificationMapper = $identificationMapper;
        $this->billingCustomerMapper = $billingCustomerMapper;
        $this->orderMapper = $orderMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    public function mapQuoteToRequestTranfer(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();

        $identification = $this->identificationMapper->map();
        $billingCustomer = $this->billingCustomerMapper->map(
            $this->createBillingCustomerMapperTransfer($quoteTransfer)
        );
        $order = $this->orderMapper->map(
            $this->createOrderMaperTransfer($quoteTransfer)
        );

        $requestTransfer->setIdentification($identification);
        $requestTransfer->setBillingCustomer($billingCustomer);
        $requestTransfer->setOrder($order);

        return $requestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\BillingCustomerMapperTransfer
     */
    protected function createBillingCustomerMapperTransfer(QuoteTransfer $quoteTransfer)
    {
        $transfer = new BillingCustomerMapperTransfer();
        $transfer->setEmail($quoteTransfer->getCustomer()->getEmail());
        $transfer->setBillingAddress($quoteTransfer->getBillingAddress());
        $transfer->setSalutation($quoteTransfer->getCustomer()->getSalutation());

        return $transfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\OrderMapperTransfer
     */
    protected function createOrderMaperTransfer(QuoteTransfer $quoteTransfer)
    {
        $transfer = new OrderMapperTransfer();
        $transfer->setOrderReference($quoteTransfer->getOrderReference());
        $transfer->setTotals($quoteTransfer->getTotals());
        $transfer->setItems($quoteTransfer->getItems());
        $transfer->setCustomerIsGuest($quoteTransfer->getCustomer()->getIsGuest());

        return $transfer;
    }
}
