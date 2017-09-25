<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SoapClient;
use SoapFault;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException;

class SoapApiAdapter implements ApiAdapterInterface
{

    /**
     * @const WSDL_PATH
     */
    const WSDL_PATH = __DIR__ . "/../Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface
     */
    protected $riskCheckRequestConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverterInterface
     */
    protected $riskCheckRequestHeaderConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface
     */
    protected $riskCheckResponseConverter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface $riskCheckRequestConverter
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverterInterface $riskCheckRequestHeaderConverter
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface $riskCheckResponseConverter
     */
    public function __construct(
        RiskCheckRequestConverterInterface $riskCheckRequestConverter,
        RiskCheckRequestHeaderConverterInterface $riskCheckRequestHeaderConverter,
        RiskCheckResponseConverterInterface $riskCheckResponseConverter
    ) {

        $this->riskCheckRequestConverter = $riskCheckRequestConverter;
        $this->riskCheckRequestHeaderConverter = $riskCheckRequestHeaderConverter;
        $this->riskCheckResponseConverter = $riskCheckResponseConverter;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @throws \SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $params = $this->riskCheckRequestConverter->convert($requestTransfer);
        $soapClient = $this->createSoapClient($requestTransfer);

        $result = $soapClient->RiskCheck($params);
        if ($result instanceof SoapFault) {
            $exceptionName = array_keys(get_object_vars($result->detail))[0];
            $exceptionObj = $result->detail->{$exceptionName};
            throw new ArvatoRssRiskCheckApiException($exceptionObj->Description);
        }

        return $this->riskCheckResponseConverter->convert($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @return SoapClient
     */
    protected function createSoapClient(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $header = $this->riskCheckRequestHeaderConverter->convert($requestTransfer);
        $options = [
            'exceptions' => false,
        ];

        $soapClient = new SoapClient(static::WSDL_PATH, $options);
        $soapClient->__setSoapHeaders($header);
        $soapClient->__setLocation(
            Config::get(ArvatoRssConstants::ARVATORSS)[ArvatoRssConstants::ARVATORSS_URL]
        );

        return $soapClient;
    }

}
