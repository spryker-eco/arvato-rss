<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
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
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $params = $this->riskCheckRequestConverter->convert($requestTransfer);
        $soapClient = $this->createSoapClient($requestTransfer);

        $result = $soapClient->RiskCheck($params);
        try {
            $this->validateResponse($result);
        } catch (ArvatoRssRiskCheckApiException $exception) {
            $responseTransfer = new ArvatoRssRiskCheckResponseTransfer();
            $responseTransfer->setIsError(true);
            $responseTransfer->setErrorMessage($exception->getMessage());
            return $responseTransfer;
        }

        return $this->riskCheckResponseConverter->convert($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @return \SoapClient
     */
    protected function createSoapClient(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $header = $this->riskCheckRequestHeaderConverter->convert($requestTransfer);
        $options = $this->getRequestOptions();
        $soapClient = new SoapClient(static::WSDL_PATH, $options);
        $soapClient->__setSoapHeaders($header);
        $soapClient->__setLocation(
            Config::get(ArvatoRssConstants::ARVATORSS_URL)
        );

        return $soapClient;
    }

    /**
     * @param \SoapFault|\stdClass $result
     *
     * @throws \SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException
     *
     * @return void
     */
    protected function validateResponse($result)
    {
        if (is_soap_fault($result)) {
            $message = $this->extractExceptionMessage($result);
            throw new ArvatoRssRiskCheckApiException($message);
        }
    }

    /**
     * @param \SoapFault $result
     *
     * @return string
     */
    protected function extractExceptionMessage(SoapFault $result)
    {
        if (isset($result->detail) && !empty(array_keys(get_object_vars($result->detail))[0])) {
            $exceptionName = array_keys(get_object_vars($result->detail))[0];
            $exceptionObj = $result->detail->{$exceptionName};
            return $exceptionObj->Description;
        }

        return $result->getMessage();
    }

    /**
     * @return array
     */
    protected function getRequestOptions()
    {
        return [
            'exceptions' => false,
        ];
    }
}
