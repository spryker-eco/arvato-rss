<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use SoapHeader;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssIdentificationApiConfig;

class RequestHeaderConverter implements RequestHeaderConverterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $arvatoRssIdentificationRequestTransfer
     *
     * @return \SoapHeader
     */
    public function convert(ArvatoRssIdentificationRequestTransfer $arvatoRssIdentificationRequestTransfer)
    {
        $requestData = $this->createRequestData($arvatoRssIdentificationRequestTransfer);

        return $this->createRequestHeader($requestData);
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
     * @param array $requestData
     *
     * @return \SoapHeader
     */
    protected function createRequestHeader($requestData)
    {
        return new SoapHeader(
            ArvatoRssIdentificationApiConfig::ARVATORSS_API_IDENTIFICATION_NAMESPACE,
            ArvatoRssIdentificationApiConfig::ARVATORSS_API_IDENTIFICATION_HEADER_NAME,
            $requestData
        );
    }

    /**
     * @return array
     */
    protected function getRequestFields()
    {
        return [
            ArvatoRssIdentificationApiConfig::ARVATORSS_API_CLIENTID => 'clientId',
            ArvatoRssIdentificationApiConfig::ARVATORSS_API_AUTHORISATION => 'authorisation',
        ];
    }
}
