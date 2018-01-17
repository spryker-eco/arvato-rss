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
        $responseTransfer->setCommunicationToken($response->Decision->CommunicationToken);

        if (isset($response->Details)) {
            $this->processBillingAddressResponse($responseTransfer, $response->Details->BillingCustomerResult);
            if (isset($response->Details->DeliveryCustomerResult)) {
                $this->processDeliveryAddressResponse($responseTransfer, $response->Details->DeliveryCustomerResult);
            }
        }

        return $responseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer $responseTransfer
     * @param \stdClass $response
     *
     * @return void
     */
    protected function processBillingAddressResponse(
        ArvatoRssRiskCheckResponseTransfer $responseTransfer,
        stdClass $response
    ) {
        if (isset($response->ServiceResults->AddressValidationResponse)) {
            $responseTransfer->setBillingAddressValidation(
                $this->convertAddressValidationResponse(
                    $response->ServiceResults->AddressValidationResponse
                )
            );
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer $responseTransfer
     * @param \stdClass $response
     *
     * @return void
     */
    protected function processDeliveryAddressResponse(
        ArvatoRssRiskCheckResponseTransfer $responseTransfer,
        stdClass $response
    ) {
        if (isset($response->ServiceResults->AddressValidationResponse)) {
            $responseTransfer->setDeliveryAddressValidation(
                $this->convertAddressValidationResponse(
                    $response->ServiceResults->AddressValidationResponse
                )
            );
        }
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
