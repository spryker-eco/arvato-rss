<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\ResponseToRiskCheckResponseTransferConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToArrayConverter;

class SoapApiAdapter implements ApiAdapterInterface
{

    /**
     * @const WSDL_PATH
     */
    const WSDL_PATH = __DIR__."/../../../../../assets/risk-solution-services.v2.1.wsdl";

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToArrayConverter
     */
    protected $riskCheckRequestToArrayConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\ResponseToRiskCheckResponseTransferConverter
     */
    protected $responseToRiskCheckResponseTransferConverter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestToArrayConverter $riskCheckRequestToArrayConverter
     */
    public function __construct(
        RiskCheckRequestToArrayConverter $riskCheckRequestToArrayConverter,
        ResponseToRiskCheckResponseTransferConverter $responseToRiskCheckResponseTransferConverter
    )
    {
        $this->riskCheckRequestToArrayConverter = $riskCheckRequestToArrayConverter;
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
        $options = [];
        //TODO: get client id and password for request from configuration.
        $soapClient = new \SoapClient(static::WSDL_PATH, $options);
        $result = $soapClient->RiskCheck($params);
        //TODO: process the response and convert it to the response transfer.
    }

}