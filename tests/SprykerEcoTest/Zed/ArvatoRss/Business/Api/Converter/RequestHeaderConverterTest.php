<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Converter;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\ArvatoRssIdentificationRequestBuilder;
use SoapHeader;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssIdentificationApiConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverter;

class RequestHeaderConverterTest extends Test
{
    /**
     * @return void
     */
    public function testConvert()
    {
        $converter = new RequestHeaderConverter();
        $identificationTransfer = $this->createIdentificationTransfer();
        $result = $converter->convert($identificationTransfer);

        $this->assertInstanceOf(SoapHeader::class, $result);
        $this->assertEquals(
            $identificationTransfer
                ->getClientId(),
            $result->data[ArvatoRssIdentificationApiConfig::ARVATORSS_API_CLIENTID]
        );

        $this->assertEquals(
            $identificationTransfer
                ->getAuthorisation(),
            $result->data[ArvatoRssIdentificationApiConfig::ARVATORSS_API_AUTHORISATION]
        );
    }

    /**
     * @return \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer
     */
    protected function createIdentificationTransfer()
    {
        return (new ArvatoRssIdentificationRequestBuilder())->build();
    }
}
