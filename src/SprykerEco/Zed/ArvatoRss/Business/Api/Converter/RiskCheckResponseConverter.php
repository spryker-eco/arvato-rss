<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssAddressValidationResponseTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use stdClass;

class RiskCheckResponseConverter implements RiskCheckResponseConverterInterface
{
    /**
     * @param \stdClass $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function convert(stdClass $response)
    {
        $responseTransfer = new ArvatoRssRiskCheckResponseTransfer();

        $responseTransfer->setResult($response->Decision->Result);
        $responseTransfer->setResultCode($response->Decision->ResultCode);
        $responseTransfer->setActionCode($response->Decision->ActionCode);
        $responseTransfer->setResultText($response->Decision->ResultText);

        if (isset($response->Details)) {
            $responseTransfer->setBillingAddressValidation(
                $this->convertAddressValidationResponse(
                    $response->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse
                )
            );

            $responseTransfer->setDeliveryAddressValidation(
                $this->convertAddressValidationResponse(
                    $response->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse
                )
            );
        }

        return $responseTransfer;
    }

    /**
     * @param \stdClass $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssAddressValidationResponseTransfer
     */
    protected function convertAddressValidationResponse(stdClass $response)
    {
        $addressValidationResponse = new ArvatoRssAddressValidationResponseTransfer();

        $addressValidationResponse->setReturnCode($response->ReturnCode);
        $addressValidationResponse->setStreet($response->Street);
        $addressValidationResponse->setStreetNumber($response->StreetNumber);
        $addressValidationResponse->setZipCode($response->ZipCode);
        $addressValidationResponse->setCity($response->City);
        $addressValidationResponse->setCountry($response->Country);

        if (isset($response->StreetNumberAdditional)) {
            $addressValidationResponse->setStreetNumberAdditional($response->StreetNumberAdditional);
        }

        return $addressValidationResponse;
    }
}
