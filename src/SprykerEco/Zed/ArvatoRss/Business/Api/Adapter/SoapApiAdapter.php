<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\ArvatoRssResponseConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter;

class SoapApiAdapter implements ApiAdapterInterface
{

    /**
     * @const string WSDL_PATH
     */
    const WSDL_PATH = __DIR__."/../Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter
     */
    protected $riskCheckRequestConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter
     */
    protected $riskCheckRequestHeaderConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\ArvatoRssResponseConverter
     */
    protected $riskCheckResponseConverter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter $riskCheckRequestConverter
     */
    public function __construct(
        RiskCheckRequestConverter $riskCheckRequestConverter,
        RiskCheckRequestHeaderConverter $riskCheckRequestHeaderConverter,
        ArvatoRssResponseConverter $riskCheckResponseConverter
    )
    {
        $this->riskCheckRequestConverter = $riskCheckRequestConverter;
        $this->riskCheckRequestHeaderConverter = $riskCheckRequestHeaderConverter;
        $this->riskCheckResponseConverter = $riskCheckResponseConverter;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $params = $this->riskCheckRequestConverter->convert($requestTransfer);
        $soapClient = $this->createSoapClient($requestTransfer);
        $response = $soapClient->RiskCheck($params);
        //TODO: check if the response has an exception
        $this->handleExceptions($response);

        return $this->riskCheckResponseConverter->convert($response);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @return \SoapClient
     */
    protected function createSoapClient(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $header = $this->riskCheckRequestHeaderConverter->convert($requestTransfer);
        $options = [
            'exceptions' => false
        ];
        $soapClient = new \SoapClient(static::WSDL_PATH, $options);
        $soapClient->__setSoapHeaders($header);
        $soapClient->__setLocation(Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_URL]);

        return $soapClient;
    }

    /**
     * @param $response
     *
     * @return void
     */
    protected function handleExceptions($response)
    {
        //TODO: throw exception here if something went wrong
    }

}