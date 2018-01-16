<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Converter;

use Codeception\TestCase\Test;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter;
use stdClass;

class RiskCheckResponseConverterTest extends Test
{
    /**
     * @return void
     */
    public function testConvert()
    {
        $converter = new RiskCheckResponseConverter();
        $response = $this->createResponse();
        $expected = $this->createExpectedResult($response);
        $actual = $converter->convert($response);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return \stdClass
     */
    protected function createResponse()
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
     * @param \stdClass $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    protected function createExpectedResult($response)
    {
        return (new ArvatoRssRiskCheckResponseTransfer())
            ->setResult($response->Decision->Result)
            ->setResultCode($response->Decision->ResultCode)
            ->setActionCode($response->Decision->ActionCode)
            ->setResultText($response->Decision->ResultText)
            ->setCommunicationToken($response->Decision->CommunicationToken);
    }
}
