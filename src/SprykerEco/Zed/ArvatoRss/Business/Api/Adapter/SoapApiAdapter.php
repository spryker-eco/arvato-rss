<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException;

class SoapApiAdapter implements ApiAdapterInterface
{

    /**
     * @const WSDL_PATH
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
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter
     */
    protected $riskCheckResponseConverter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter $riskCheckRequestConverter
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter $riskCheckRequestHeaderConverter
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter $riskCheckResponseConverter
     */
    public function __construct(
        RiskCheckRequestConverter $riskCheckRequestConverter,
        RiskCheckRequestHeaderConverter $riskCheckRequestHeaderConverter,
        RiskCheckResponseConverter $riskCheckResponseConverter
    )
    {
        $this->riskCheckRequestConverter = $riskCheckRequestConverter;
        $this->riskCheckRequestHeaderConverter = $riskCheckRequestHeaderConverter;
        $this->riskCheckResponseConverter = $riskCheckResponseConverter;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfers
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $params = $this->riskCheckRequestConverter->convert($requestTransfer);
        $soapClient = $this->createSoapClient($requestTransfer);

        $result = $soapClient->RiskCheck($params);
        if ($result instanceof \SoapFault) {
            $exceptionName = array_keys(get_object_vars($result->detail))[0];
            $exceptionObj = $result->detail->{$exceptionName};
            throw new ArvatoRssRiskCheckApiException($exceptionObj->Description);
        }

        return $this->riskCheckResponseConverter->convert($result);
    }

    /**
     * @return \SoapClient
     */
    protected function createSoapClient($requestTransfer)
    {
        $header = $this->riskCheckRequestHeaderConverter->convert($requestTransfer);
        $options = [
            'exceptions' => false
        ];

        $soapClient = new \SoapClient(static::WSDL_PATH, $options);
        $soapClient->__setSoapHeaders($header);
        // TODO: add config get service to avoid direct config call
        $soapClient->__setLocation(
            Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_URL]
        );

        return $soapClient;
    }

}