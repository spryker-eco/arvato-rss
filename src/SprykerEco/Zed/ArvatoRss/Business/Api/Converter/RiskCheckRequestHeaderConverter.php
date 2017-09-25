<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SoapHeader;

class RiskCheckRequestHeaderConverter implements RiskCheckRequestHeaderConverterInterface
{

    /**
     * @const string IDENTIFICATION_NAMESPACE
     */
    const IDENTIFICATION_NAMESPACE = 'urn:risk-solution-services-types:v2.1';

    /**
     * @const string IDENTIFICATION_HEADER_NAME
     */
    const IDENTIFICATION_HEADER_NAME = 'Identification';

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
            self::IDENTIFICATION_NAMESPACE,
            self::IDENTIFICATION_HEADER_NAME,
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
            $result[$key] = $arvatoRssIdentificationRequestTransfer->{'get' . $item}();
        });

        return $result;
    }

    /**
     * @return array
     */
    protected function getRequestFields()
    {
        return [
            'ClientID' => 'clientId',
            'Authorisation' => 'authorisation',
        ];
    }

}
