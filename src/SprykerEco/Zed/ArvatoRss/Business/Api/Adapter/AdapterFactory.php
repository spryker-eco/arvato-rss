<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger\TransactionLogger;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverter;

class AdapterFactory extends AbstractBusinessFactory implements AdapterFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface
     */
    public function createRequestHeaderConverter()
    {
        return new RequestHeaderConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface
     */
    public function createRiskCheckRequestConverter()
    {
        return new RiskCheckRequestConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface
     */
    public function createRiskCheckResponseConverter()
    {
        return new RiskCheckResponseConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverterInterface
     */
    public function createStoreOrderRequestConverter()
    {
        return new StoreOrderRequestConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverterInterface
     */
    public function createStoreOrderResponseConverter()
    {
        return new StoreOrderResponseConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger\TransactionLogger
     */
    public function createTransactionLogger()
    {
        return new TransactionLogger();
    }
}
