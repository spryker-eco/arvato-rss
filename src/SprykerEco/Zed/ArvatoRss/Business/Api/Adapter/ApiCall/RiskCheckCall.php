<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall;

use SoapClient;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException;

class RiskCheckCall extends AbstractCall
{
    /**
     * @const string
     */
    const CALL_TYPE = ArvatoRssApiConfig::TRANSACTION_TYPE_RISK_CHECK;

    /**
     * @param \SoapClient $soapClient
     * @param array $params
     *
     * @return \stdClass|\SoapFault
     */
    protected function executeCall(SoapClient $soapClient, array $params)
    {
        return $soapClient->RiskCheck($params);
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
        throw new ArvatoRssRiskCheckApiException($message);
    }
}