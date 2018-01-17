<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @param stdClass $response
     * @param ArvatoRssRiskCheckResponseTransfer $expected
     *
     * @dataProvider provideResponseData
     *
     * @return void
     */
    public function testConvert(stdClass $response, ArvatoRssRiskCheckResponseTransfer $expected)
    {
        $converter = new RiskCheckResponseConverter();
        $actual = $converter->convert($response);

        $this->assertEquals($expected, $actual);

        $this->testDeliveryPresents($converter);
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
            'response without address' => [$responseWithoutAddress, $expectedWithoutAddress]
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
     * @return stdClass
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
     * @param stdClass $response
     *
     * @return ArvatoRssAddressValidationResponseTransfer
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

    /**
     * @param RiskCheckResponseConverter $converter
     */
    protected function testDeliveryPresents(RiskCheckResponseConverter $converter)
    {
        $result = $converter->convert($this->createResponseWithDelivery());

        $this->assertInstanceOf(
            ArvatoRssAddressValidationResponseTransfer::class,
            $result->getDeliveryAddressValidation()
        );

        $result = $converter->convert($this->createResponseWithBilling());
        $this->assertEmpty($result->getDeliveryAddressValidation());
    }

    /**
     * @return stdClass
     */
    protected function createResponseWithDelivery()
    {
        $response = $this->createResponseWithBilling();
        $response->Details->DeliveryCustomerResult = new stdClass();
        $response->Details->DeliveryCustomerResult->ServiceResults = new stdClass();
        $response->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse = new stdClass();
        $response->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse->ReturnCode = 'ReturnCode';
        $response->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse->Street = 'Street';
        $response->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse->StreetNumber = 'StreetNumber';
        $response->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse->ZipCode = 'ZipCode';
        $response->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse->City = 'City';
        $response->Details->DeliveryCustomerResult->ServiceResults->AddressValidationResponse->Country = 'Country';

        return $response;
    }

    /**
     * @return stdClass
     */
    protected function createResponseWithBilling()
    {
        $response = $this->createResponse();
        $response->Details = new stdClass();
        $response->Details->BillingCustomerResult = new stdClass();
        $response->Details->BillingCustomerResult->ServiceResults = new stdClass();
        $response->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse = new stdClass();
        $response->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse->ReturnCode = 'ReturnCode';
        $response->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse->Street = 'Street';
        $response->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse->StreetNumber = 'StreetNumber';
        $response->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse->ZipCode = 'ZipCode';
        $response->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse->City = 'City';
        $response->Details->BillingCustomerResult->ServiceResults->AddressValidationResponse->Country = 'Country';

        return $response;
    }
}
