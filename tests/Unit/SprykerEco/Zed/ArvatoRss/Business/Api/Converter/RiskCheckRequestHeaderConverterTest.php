<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use PHPUnit\Framework\TestCase;
use SoapHeader;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter;

class RiskCheckRequestHeaderConverterTest extends TestCase
{

    /**
     * @return void
     */
    public function testConvert()
    {
        $converter = new RiskCheckRequestHeaderConverter();
        $requestTranfer = $this->createRequestTransfer();
        $expected = $this->createExpectedResult($requestTranfer);
        $actual = $converter->convert($requestTranfer);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer
     */
    protected function createRequestTransfer()
    {
        $requestTransfer = new ArvatoRssRiskCheckRequestTransfer();
        $identificationTransfer = new ArvatoRssIdentificationRequestTransfer();
        $identificationTransfer
            ->setClientId('123123')
            ->setAuthorisation('password');
        $requestTransfer->setIdentification($identificationTransfer);

        return $requestTransfer;
    }

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter $requestTransfer
     *
     * @return \SoapHeader
     */
    protected function createExpectedResult($requestTransfer)
    {
        $identification = $requestTransfer->getIdentification();
        $requestData = [
            'ClientID' => $identification->getClientId(),
            'Authorisation' => $identification->getAuthorisation(),
        ];
        $soapHeader = new SoapHeader(
            RiskCheckRequestHeaderConverter::IDENTIFICATION_NAMESPACE,
            RiskCheckRequestHeaderConverter::IDENTIFICATION_HEADER_NAME,
            $requestData
        );

        return $soapHeader;
    }

}
