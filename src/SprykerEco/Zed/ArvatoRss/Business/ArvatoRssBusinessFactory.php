<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterService;
use SprykerEco\Zed\ArvatoRss\ArvatoRssDependencyProvider;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactory;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\DeliveryCustomerMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapper;
use SprykerEco\Zed\ArvatoRss\Business\Handler\RiskCheckHandler;
use SprykerEco\Zed\ArvatoRss\Business\Handler\StoreOrderHandler;

/**
 * @method \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig getConfig()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface getRepository()
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
            $this->createSoapApiAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\StoreOrderRequestMapperInterface
     */
    public function createStoreOrderRequestMapper()
    {
        return new StoreOrderRequestMapper(
            $this->createIdentificationMapper(),
            $this->createOrderMapper(),
            $this->getRepository(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapperInterface
     */
    public function createRiskCheckRequestMapper()
    {
        return new RiskCheckRequestMapper(
            $this->createIdentificationMapper(),
            $this->createBillingCustomerMapper(),
            $this->createDeliveryCustomerMapper(),
            $this->createOrderMapper()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapperInterface
     */
    public function createIdentificationMapper()
    {
        return new IdentificationMapper(
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\BillingCustomerMapperInterface
     */
    public function createBillingCustomerMapper()
    {
        return new BillingCustomerMapper(
            $this->createIso3166Converter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\DeliveryCustomerMapperInterface
     */
    public function createDeliveryCustomerMapper()
    {
        return new DeliveryCustomerMapper(
            $this->createIso3166Converter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\OrderMapperInterface
     */
    public function createOrderMapper()
    {
        return new OrderMapper(
            $this->getMoneyFacade(),
            $this->getStoreFacade()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToStoreInterface
     */
    public function getStoreFacade()
    {
        return $this->getProvidedDependency(ArvatoRssDependencyProvider::FACADE_STORE);
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapperInterface
     */
    public function createRiskCheckResponseMapper()
    {
        return new RiskCheckResponseMapper();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface
     */
    public function createSoapApiAdapter()
    {
        return new SoapApiAdapter(
            $this->createAdapterFactory()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface
     */
    public function getMoneyFacade()
    {
        return $this->getProvidedDependency(ArvatoRssDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface
     */
    public function createIso3166Converter()
    {
        return new Iso3166ConverterService();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactoryInterface
     */
    public function createAdapterFactory()
    {
        return new AdapterFactory();
    }
}
