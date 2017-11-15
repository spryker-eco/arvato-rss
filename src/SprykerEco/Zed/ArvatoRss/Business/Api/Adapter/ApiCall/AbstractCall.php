<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger\ApiCallLoggerInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface;
use SoapClient;

abstract class AbstractCall implements ApiCallInterface
{
    /**
     * @const string
     */
    const WSDL_PATH = __DIR__ . "/../../Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @const string
     */
    const CALL_TYPE = 'UNKNOWN';

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface
     */
    protected $requestHeaderConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger\ApiCallLoggerInterface
     */
    protected $apiCallLogger;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface $requestHeaderConverter
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\Transaction\Logger\ApiCallLoggerInterface $apiCallLogger
     */
    public function __construct(
        RequestHeaderConverterInterface $requestHeaderConverter,
        ApiCallLoggerInterface $apiCallLogger
    )
    {
        $this->requestHeaderConverter = $requestHeaderConverter;
        $this->apiCallLogger = $apiCallLogger;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     * @param array $params
     *
     * @return \stdClass
     */
    public function execute(
        ArvatoRssIdentificationRequestTransfer $identification,
        array $params
    )
    {
        $result = $this->sendRequest($identification, $params);

        $this->apiCallLogger->log(
            $this->retrieveOrderNumber($params),
            static::CALL_TYPE,
            $result->Decision->ResultCode,
            $params,
            $result
        );

        return $result;
    }

    /**
     * @param \SoapClient $soapClient
     * @param array $params
     *
     * @return \stdClass|\SoapFault
     */
    abstract protected function executeCall(SoapClient $soapClient, array $params);

    /**
     * @param $message
     *
     * @return void
     *
     * @throws \Exception
     */
    abstract protected function throwValidationException($message);

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     * @param array $params
     *
     * @return \SoapFault|\stdClass
     */
    protected function sendRequest(
        ArvatoRssIdentificationRequestTransfer $identification,
        array $params
    )
    {
        $soapClient = $this->createSoapClient(
            $identification
        );
        $result = $this->executeCall($soapClient, $params);
        $this->validateResponse($result);

        return $result;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     *
     * @return \SoapClient
     */
    protected function createSoapClient(ArvatoRssIdentificationRequestTransfer $identification)
    {
        $header = $this->requestHeaderConverter->convert($identification);
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
     * @throws \Exception
     *
     * @return void
     */
    protected function validateResponse($result)
    {
        if (is_soap_fault($result)) {
            $message = $this->extractExceptionMessage($result);
            $this->throwValidationException($message);
        }
    }

    /**
     * @param \SoapFault $result
     *
     * @return string
     */
    protected function extractExceptionMessage(\SoapFault $result)
    {
        if (isset($result->detail) && !empty(array_keys(get_object_vars($result->detail))[0])) {
            $exceptionName = array_keys(get_object_vars($result->detail))[0];
            $exceptionObj = $result->detail->{$exceptionName};
            return $exceptionObj->Description;
        }

        return $result->getMessage();
    }

    protected function retrieveOrderNumber($params)
    {
        return isset(
            $params[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER]
            [ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER_NUMBER])?
            $params[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER]
            [ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER_NUMBER]:
            '';
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