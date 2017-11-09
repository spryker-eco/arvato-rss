<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use DateTime;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderItemTransfer;
use Generated\Shared\Transfer\ArvatoRssOrderTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Config\Config;
use Spryker\Shared\Kernel\Store;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

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
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface $identificationMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface $billingCustomerMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface $orderMapper
     */
    public function __construct(
        IdentificationMapperInterface $identificationMapper,
        OrderMapperInterface $orderMapper
    )
    {
        $this->identificationMapper = $identificationMapper;
        $this->orderMapper = $orderMapper;
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
}
