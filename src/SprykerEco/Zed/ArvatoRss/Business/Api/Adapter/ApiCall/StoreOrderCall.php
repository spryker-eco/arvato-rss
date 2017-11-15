<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall;

use SoapClient;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssStoreOrderApiException;

class StoreOrderCall extends AbstractCall
{
    /**
     * @const string
     */
    const CALL_TYPE = ArvatoRssApiConfig::TRANSACTION_TYPE_STORE_ORDER;

    /**
     * @param \SoapClient $soapClient
     * @param array $params
     *
     * @return \stdClass
     */
    protected function executeCall(SoapClient $soapClient, array $params)
    {
        return $soapClient->StoreOrder($params);
    }

    /**
     * @param $message
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function throwValidationException($message)
    {
        throw new ArvatoRssStoreOrderApiException($message);
    }
}