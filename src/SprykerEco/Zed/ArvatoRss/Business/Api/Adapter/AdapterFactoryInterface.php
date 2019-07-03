<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ApiCallLoggerInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverterInterface;

interface AdapterFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface
     */
    public function createRequestHeaderConverter(): RequestHeaderConverterInterface;

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface
     */
    public function createRiskCheckRequestConverter(): RiskCheckRequestConverterInterface;

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface
     */
    public function createRiskCheckResponseConverter(): RiskCheckResponseConverterInterface;

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverterInterface
     */
    public function createStoreOrderRequestConverter(): StoreOrderRequestConverterInterface;

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverterInterface
     */
    public function createStoreOrderResponseConverter(): StoreOrderResponseConverterInterface;

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ApiCallLoggerInterface
     */
    public function createApiCallLogger(): ApiCallLoggerInterface;

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface
     */
    public function createStoreOrderCall(): ApiCallInterface;

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface
     */
    public function createRiskCheckCall(): ApiCallInterface;
}
