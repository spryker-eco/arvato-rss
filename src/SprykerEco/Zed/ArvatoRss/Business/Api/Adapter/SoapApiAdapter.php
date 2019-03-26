<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssStoreOrderApiException;

class SoapApiAdapter implements ApiAdapterInterface
{
    public const WSDL_PATH = __DIR__ . "/../Etc/risk-solution-services.v2.1.wsdl";

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
        try {
            $result = $this->adapterFactory
                ->createRiskCheckCall()
                ->execute(
                    $requestTransfer->getIdentification(),
                    $params
                );
        } catch (ArvatoRssRiskCheckApiException $exception) {
            $responseTransfer = new ArvatoRssRiskCheckResponseTransfer();
            $responseTransfer->setIsError(true);
            $responseTransfer->setErrorMessage($exception->getMessage());
            return $responseTransfer;
        }

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
        try {
            $result = $this->adapterFactory
                ->createStoreOrderCall()
                ->execute(
                    $requestTransfer->getIdentification(),
                    $params
                );
        } catch (ArvatoRssStoreOrderApiException $exception) {
            $responseTransfer = new ArvatoRssStoreOrderResponseTransfer();
            $responseTransfer->setIsError(true);
            $responseTransfer->setErrorMessage($exception->getMessage());

            return $responseTransfer;
        }

        return $this->adapterFactory->createStoreOrderResponseConverter()->convert($result);
    }
}
