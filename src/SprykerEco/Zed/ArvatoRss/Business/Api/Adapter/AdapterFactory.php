<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ApiCallLogger;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ApiCallLoggerInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ArvatoRssApiCallLogger;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ArvatoRssApiCallLoggerInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\RiskCheckCall;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\StoreOrderCall;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverterInterface;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface getRepository()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssEntityManagerInterface getEntityManager()()
 */
class AdapterFactory extends AbstractBusinessFactory implements AdapterFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface
     */
    public function createRequestHeaderConverter(): RequestHeaderConverterInterface
    {
        return new RequestHeaderConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface
     */
    public function createRiskCheckRequestConverter(): RiskCheckRequestConverterInterface
    {
        return new RiskCheckRequestConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface
     */
    public function createRiskCheckResponseConverter(): RiskCheckResponseConverterInterface
    {
        return new RiskCheckResponseConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverterInterface
     */
    public function createStoreOrderRequestConverter(): StoreOrderRequestConverterInterface
    {
        return new StoreOrderRequestConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverterInterface
     */
    public function createStoreOrderResponseConverter(): StoreOrderResponseConverterInterface
    {
        return new StoreOrderResponseConverter();
    }

    /**
     * @deprecated Use `\SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactory::createArvatoRssApiCallLogger()` instead.
     *
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ApiCallLoggerInterface
     */
    public function createApiCallLogger(): ApiCallLoggerInterface
    {
        return new ApiCallLogger();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ArvatoRssApiCallLoggerInterface
     */
    public function createArvatoRssApiCallLogger(): ArvatoRssApiCallLoggerInterface
    {
        return new ArvatoRssApiCallLogger(
            $this->getRepository(),
            $this->getEntityManager()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface
     */
    public function createRiskCheckCall(): ApiCallInterface
    {
        return new RiskCheckCall(
            $this->createRequestHeaderConverter(),
            $this->createArvatoRssApiCallLogger()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface
     */
    public function createStoreOrderCall(): ApiCallInterface
    {
        return new StoreOrderCall(
            $this->createRequestHeaderConverter(),
            $this->createArvatoRssApiCallLogger()
        );
    }
}
