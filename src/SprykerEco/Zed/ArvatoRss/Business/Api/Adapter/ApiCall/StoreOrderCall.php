<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
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
    public const CALL_TYPE = ArvatoRssApiConfig::TRANSACTION_TYPE_STORE_ORDER;

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
     * @param string $message
     *
     * @throws \SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssStoreOrderApiException
     *
     * @return void
     */
    protected function throwValidationException($message)
    {
        throw new ArvatoRssStoreOrderApiException($message);
    }
}
