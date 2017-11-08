<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

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

        return $response;
    }

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverterInterface $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    protected function createExpectedResult($response)
    {
        return (new ArvatoRssRiskCheckResponseTransfer())
            ->setResult($response->Decision->Result)
            ->setResultCode($response->Decision->ResultCode)
            ->setActionCode($response->Decision->ActionCode)
            ->setResultText($response->Decision->ResultText);
    }
}
