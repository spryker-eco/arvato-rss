<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use SoapClient;
use SoapFault;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ApiCallLoggerInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface;

abstract class AbstractCall implements ApiCallInterface
{
    /**
     * @const string
     */
    public const WSDL_PATH = __DIR__ . "/../../Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @const string
     */
    public const CALL_TYPE = 'UNKNOWN';

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface
     */
    protected $requestHeaderConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ApiCallLoggerInterface
     */
    protected $apiCallLogger;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverterInterface $requestHeaderConverter
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger\ApiCallLoggerInterface $apiCallLogger
     */
    public function __construct(
        RequestHeaderConverterInterface $requestHeaderConverter,
        ApiCallLoggerInterface $apiCallLogger
    ) {
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
    ) {
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
     * @param string $message
     *
     * @throws \Exception
     *
     * @return void
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
    ) {
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
     * @param array $params
     *
     * @return string
     */
    protected function retrieveOrderNumber(array $params)
    {
        return isset(
            $params[ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER][ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER_NUMBER]
        ) ?
            $params[ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER][ArvatoRssRequestApiConfig::ARVATORSS_API_ORDER_NUMBER] :
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
