<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
    public const CALL_TYPE = ArvatoRssApiConfig::TRANSACTION_TYPE_RISK_CHECK;

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
     * @param string $message
     *
     * @throws \SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException
     *
     * @return void
     */
    protected function throwValidationException($message)
    {
        throw new ArvatoRssRiskCheckApiException($message);
    }
}
