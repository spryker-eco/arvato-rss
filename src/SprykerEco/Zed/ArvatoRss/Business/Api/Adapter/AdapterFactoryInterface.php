<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

interface AdapterFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverter
     */
    public function createRequestHeaderConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface
     */
    public function createRiskCheckRequestConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface
     */
    public function createRiskCheckResponseConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverterInterface
     */
    public function createStoreOrderRequestConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverterInterface
     */
    public function createStoreOrderResponseConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger\ApiCallLogger
     */
    public function createApiCallLogger();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface
     */
    public function createStoreOrderCall();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface
     */
    public function createRiskCheckCall();
}
