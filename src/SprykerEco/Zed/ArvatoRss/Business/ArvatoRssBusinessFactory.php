<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterService;
use SprykerEco\Zed\ArvatoRss\ArvatoRssDependencyProvider;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactory;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderResponseMapper;
use SprykerEco\Zed\ArvatoRss\Business\Handler\RiskCheckHandler;
use SprykerEco\Zed\ArvatoRss\Business\Handler\StoreOrderHandler;

/**
 * @method \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig getConfig()
 */
class ArvatoRssBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Handler\RiskCheckHandlerInterface
     */
    public function createRiskCheckHandler()
    {
        return new RiskCheckHandler(
            $this->createRiskCheckRequestMapper(),
            $this->createRiskCheckResponseMapper(),
            $this->createSoapApiAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Handler\StoreOrderHandlerInterface
     */
    public function createStoreOrderHandler()
    {
        return new StoreOrderHandler(
            $this->createStoreOrderRequestMapper(),
            $this->createStoreOrderResponseMapper(),
            $this->createSoapApiAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapperInterface
     */
    protected function createStoreOrderRequestMapper()
    {
        return new StoreOrderRequestMapper(
            $this->createIdentificationMapper(),
            $this->createOrderMapper()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderResponseMapperInterface
     */
    protected function createStoreOrderResponseMapper()
    {
        return new StoreOrderResponseMapper();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapperInterface
     */
    protected function createRiskCheckRequestMapper()
    {
        return new RiskCheckRequestMapper(
            $this->createIdentificationMapper(),
            $this->createBillingCustomerMapper(),
            $this->createOrderMapper()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface
     */
    protected function createIdentificationMapper()
    {
        return new IdentificationMapper(
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface
     */
    protected function createBillingCustomerMapper()
    {
        return new BillingCustomerMapper(
            $this->createIso3166Converter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface
     */
    protected function createOrderMapper()
    {
        return new OrderMapper(
            $this->getMoneyFacade(),
            $this->getStoreFacade(),
            $this->getConfig()
        );
    }

    protected function getStoreFacade()
    {
        return $this->getProvidedDependency(ArvatoRssDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapperInterface
     */
    protected function createRiskCheckResponseMapper()
    {
        return new RiskCheckResponseMapper();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface
     */
    protected function createSoapApiAdapter()
    {
        return new SoapApiAdapter(
            $this->createAdapterFactory()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface
     */
    protected function getMoneyFacade()
    {
        return $this->getProvidedDependency(ArvatoRssDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface
     */
    protected function createIso3166Converter()
    {
        return new Iso3166ConverterService();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactoryInterface
     */
    protected function createAdapterFactory()
    {
        return new AdapterFactory();
    }
}
