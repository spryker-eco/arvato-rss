<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Converter;

use Codeception\TestCase\Test;
use Generated\Shared\Transfer\ArvatoRssAddressValidationResponseTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter;
use stdClass;

class RiskCheckResponseConverterTest extends Test
{
    /**
     * @dataProvider provideResponseData
     *
     * @param \stdClass $response
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer $expected
     *
     * @return void
     */
    public function testConvert(stdClass $response, ArvatoRssRiskCheckResponseTransfer $expected)
    {
        $converter = new RiskCheckResponseConverter();
        $actual = $converter->convert($response);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public static function provideResponseData()
    {
        $simpleResponse = self::createResponse();
        $simpleExpected = self::createExpectedResult($simpleResponse);

        $responseWithoutAddress = $simpleResponse;
        $responseWithoutAddress->Details = new stdClass();
        $responseWithoutAddress->Details->BillingCustomerResult = self::createAddressResponse();
        $responseWithoutAddress->Details->DeliveryCustomerResult = new stdClass();
        $responseWithoutAddress->Details->DeliveryCustomerResult->ServiceResults = new stdClass();
        $expectedWithoutAddress = $simpleExpected
            ->setBillingAddressValidation(
                self::createAddressValidationTransfer(
                    $responseWithoutAddress->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse
                )
            );

        $responseWithAddresses = $responseWithoutAddress;
        $responseWithAddresses->Details->DeliveryCustomerResult = self::createAddressResponse();
        $expectedWithAddress = $expectedWithoutAddress
            ->setDeliveryAddressValidation(
                self::createAddressValidationTransfer(
                    $responseWithAddresses->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse
                )
            );

        $responseWithAdditionalAddress = $responseWithAddresses;
        $responseWithAdditionalAddress->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse->StreetNumberAdditional = '123';
        $responseWithAdditionalAddress->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse->StreetNumberAdditional = '123';
        $expectedWithAdditionalField = $expectedWithAddress;
        $expectedWithAdditionalField
            ->getBillingAddressValidation()
            ->setStreetNumberAdditional(
                $responseWithAdditionalAddress->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse->StreetNumberAdditional
            );
        $expectedWithAdditionalField
            ->getDeliveryAddressValidation()
            ->setStreetNumberAdditional(
                $responseWithAdditionalAddress->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse->StreetNumberAdditional
            );

        return [
            'simple response' => [$simpleResponse, $simpleExpected],
            'response with addresses' => [$responseWithAddresses, $expectedWithAddress],
            'response with additional address field' => [$responseWithAdditionalAddress, $expectedWithAdditionalField],
            'response without address' => [$responseWithoutAddress, $expectedWithoutAddress],
        ];
    }

    /**
     * @return \stdClass
     */
    protected static function createResponse()
    {
        $response = new stdClass();
        $response->Decision = new stdClass();
        $response->Decision->Result = 'R';
        $response->Decision->ResultCode = '123123';
        $response->Decision->ActionCode = '123123';
        $response->Decision->ResultText = 'text';
        $response->Decision->CommunicationToken = '1298748712644644';

        return $response;
    }

    /**
     * @return \stdClass
     */
    protected static function createAddressResponse()
    {
        $response = new stdClass();
        $response->ServiceResults = new stdClass();
        $response->ServiceResults->AddressValidationResponse = new stdClass();
        $response->ServiceResults->AddressValidationResponse->ReturnCode = 'ReturnCode';
        $response->ServiceResults->AddressValidationResponse->Street = 'Street';
        $response->ServiceResults->AddressValidationResponse->StreetNumber = 'StreetNumber';
        $response->ServiceResults->AddressValidationResponse->ZipCode = 'ZipCode';
        $response->ServiceResults->AddressValidationResponse->City = 'City';
        $response->ServiceResults->AddressValidationResponse->Country = 'Country';

        return $response;
    }

    /**
     * @param \stdClass $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    protected static function createExpectedResult($response)
    {
        return (new ArvatoRssRiskCheckResponseTransfer())
            ->setResult($response->Decision->Result)
            ->setResultCode($response->Decision->ResultCode)
            ->setActionCode($response->Decision->ActionCode)
            ->setResultText($response->Decision->ResultText)
            ->setCommunicationToken($response->Decision->CommunicationToken);
    }

    /**
     * @param \stdClass $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssAddressValidationResponseTransfer
     */
    protected static function createAddressValidationTransfer($response)
    {
        return (new ArvatoRssAddressValidationResponseTransfer())
            ->setReturnCode($response->ReturnCode)
            ->setStreet($response->Street)
            ->setStreetNumber($response->StreetNumber)
            ->setZipCode($response->ZipCode)
            ->setCity($response->City)
            ->setCountry($response->Country);
    }
}
