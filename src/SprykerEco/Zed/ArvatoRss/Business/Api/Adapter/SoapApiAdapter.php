<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use SoapClient;
use SoapFault;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssStoreOrderApiException;

class SoapApiAdapter implements ApiAdapterInterface
{
    const WSDL_PATH = __DIR__ . "/../Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactoryInterface
     */
    protected $adapterFactory;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactoryInterface $adapterFactory
     */
    public function __construct(
        AdapterFactoryInterface $adapterFactory
    ) {
        $this->adapterFactory = $adapterFactory;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $params = $this->adapterFactory
            ->createRiskCheckRequestConverter()
            ->convert($requestTransfer);
        $soapClient = $this->createSoapClient(
            $requestTransfer->getIdentification()
        );
        $result = $soapClient->RiskCheck($params);

        try {
            $this->validateResponse($result);
        } catch (ArvatoRssRiskCheckApiException $exception) {
            $responseTransfer = new ArvatoRssRiskCheckResponseTransfer();
            $responseTransfer->setIsError(true);
            $responseTransfer->setErrorMessage($exception->getMessage());
            return $responseTransfer;
        }

        $this->adapterFactory->createTransactionLogger()->log(
            $requestTransfer->getOrder()->getOrderNumber(),
            ArvatoRssApiConfig::TRANSACTION_TYPE_STORE_ORDER,
            $result->Decision->ResultCode,
            $params,
            $result
        );

        return $this->adapterFactory->createRiskCheckResponseConverter()->convert($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer
     */
    public function storeOrder(ArvatoRssStoreOrderRequestTransfer $requestTransfer)
    {
        $params = $this->adapterFactory
            ->createStoreOrderRequestConverter()
            ->convert($requestTransfer);
        $soapClient = $this->createSoapClient(
            $requestTransfer->getIdentification()
        );
        $result = $soapClient->StoreOrder($params);

        try {
            $this->validateResponse($result);
        } catch (ArvatoRssStoreOrderApiException $exception) {
            $responseTransfer = new ArvatoRssStoreOrderResponseTransfer();
            $responseTransfer->setIsError(true);
            $responseTransfer->setErrorMessage($exception->getMessage());

            return $responseTransfer;
        }

        $this->adapterFactory->createTransactionLogger()->log(
            $requestTransfer->getOrder()->getOrderNumber(),
            ArvatoRssApiConfig::TRANSACTION_TYPE_STORE_ORDER,
            $result->Decision->ResultCode,
            $params,
            $result
        );

        return $this->adapterFactory->createStoreOrderResponseConverter()->convert($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     *
     * @return \SoapClient
     */
    protected function createSoapClient(ArvatoRssIdentificationRequestTransfer $identification)
    {
        $header = $this->adapterFactory->createRequestHeaderConverter()->convert($identification);
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
