<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\ResponseToRiskCheckResponseTransferConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToArrayConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper;
use SprykerEco\Zed\ArvatoRss\Business\Handler\RiskCheckHandler;

/**
 * @method \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig getConfig()
 */
class ArvatoRssBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Handler\RiskCheckHandler
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
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper
     */
    protected function createRiskCheckRequestMapper()
    {
        return new RiskCheckRequestMapper();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper
     */
    protected function createRiskCheckResponseMapper()
    {
        return new RiskCheckResponseMapper();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter
     */
    protected function createSoapApiAdapter()
    {
        return new SoapApiAdapter(
            $this->createRiskCheckToArrayConverter(),
            $this->createResponseToRiskCheckResponseTransferConverter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToArrayConverter
     */
    protected function createRiskCheckToArrayConverter()
    {
        return new RiskCheckRequestToArrayConverter();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\ResponseToRiskCheckResponseTransferConverter
     */
    protected function createResponseToRiskCheckResponseTransferConverter()
    {
        return new ResponseToRiskCheckResponseTransferConverter();
    }

}
