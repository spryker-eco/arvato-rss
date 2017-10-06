<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Codeception\TestCase\Test;
use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SoapHeader;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssApiConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter;

class RiskCheckRequestHeaderConverterTest extends Test
{

    /**
     * @return void
     */
    public function testConvert()
    {
        $converter = new RiskCheckRequestHeaderConverter();
        $requestTranfer = $this->createRequestTransfer();
        $actual = $converter->convert($requestTranfer);

        $this->assertInstanceOf(SoapHeader::class, $actual);
        $this->assertEquals(
            $requestTranfer
                ->getIdentification()
                ->getClientId(),
            $actual->data[ArvatoRssApiConstants::ARVATORSS_API_CLIENTID]
        );

        $this->assertEquals(
            $requestTranfer
                ->getIdentification()
                ->getAuthorisation(),
            $actual->data[ArvatoRssApiConstants::ARVATORSS_API_AUTHORISATION]
        );
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

}
