<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\ResponseToRiskCheckResponseTransferConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToArrayConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToHeaderConverter;

class SoapApiAdapter implements ApiAdapterInterface
{

    /**
     * @const string WSDL_PATH
     */
    const WSDL_PATH = __DIR__."/../Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToArrayConverter
     */
    protected $riskCheckRequestToArrayConverter;

    protected $riskCheckRequestToHeaderConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\ResponseToRiskCheckResponseTransferConverter
     */
    protected $responseToRiskCheckResponseTransferConverter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToArrayConverter $riskCheckRequestToArrayConverter
     */
    public function __construct(
        RiskCheckRequestToArrayConverter $riskCheckRequestToArrayConverter,
        RiskCheckRequestToHeaderConverter $riskCheckRequestToHeaderConverter,
        ResponseToRiskCheckResponseTransferConverter $responseToRiskCheckResponseTransferConverter
    )
    {
        $this->riskCheckRequestToArrayConverter = $riskCheckRequestToArrayConverter;
        $this->riskCheckRequestToHeaderConverter  =$riskCheckRequestToHeaderConverter;
        $this->responseToRiskCheckResponseTransferConverter = $responseToRiskCheckResponseTransferConverter;
    }

    /**
     * @param Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $quoteTransfer
     *
     * @return Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $params = $this->riskCheckRequestToArrayConverter->convert($requestTransfer);
        $header = $this->riskCheckRequestToHeaderConverter->convert($requestTransfer);
        $options = array(
        ) ;
        $soapClient = new \SoapClient(static::WSDL_PATH, $options);
        $soapClient->__setSoapHeaders($header);
        $soapClient->__setLocation(Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_URL]);
        //TODO: catch exceptions.
        $result = $soapClient->RiskCheck($params);
        //TODO: process the response and convert it to the response transfer.
    }

}