<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SoapHeader;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssApiConstants;

class RiskCheckRequestHeaderConverter implements RiskCheckRequestHeaderConverterInterface
{

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     *
     * @return \SoapHeader
     */
    public function convert(ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer)
    {
        $identification = $arvatoRssRiskCheckRequestTransfer->getIdentification();
        $requestData = $this->createRequestData($identification);
        $soapHeader = new SoapHeader(
            ArvatoRssApiConstants::ARVATORSS_API_IDENTIFICATION_NAMESPACE,
            ArvatoRssApiConstants::ARVATORSS_API_IDENTIFICATION_HEADER_NAME,
            $requestData
        );

        return $soapHeader;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $arvatoRssIdentificationRequestTransfer
     *
     * @return array
     */
    protected function createRequestData(ArvatoRssIdentificationRequestTransfer $arvatoRssIdentificationRequestTransfer)
    {
        $result = [];
        $fields = $this->getRequestFields();
        array_walk($fields, function (
            $item,
            $key
        ) use (
            &$result,
            $arvatoRssIdentificationRequestTransfer
        ) {
            $result[$key] = $arvatoRssIdentificationRequestTransfer->{'get' . ucfirst($item)}();
        });

        return $result;
    }

    /**
     * @return array
     */
    protected function getRequestFields()
    {
        return [
            ArvatoRssApiConstants::ARVATORSS_API_CLIENTID => 'clientId',
            ArvatoRssApiConstants::ARVATORSS_API_AUTHORISATION => 'authorisation',
        ];
    }

}
