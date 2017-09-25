<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use PHPUnit\Framework\TestCase;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter;
use StdClass;

class RiskCheckResponseConverterTest extends TestCase
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
        $response = new StdClass();
        $response->Decision->Result = 'R';
        $response->Decision->ResultCode = '123123';
        $response->Decision->ActionCode = '123123';
        $response->Decision->ResultText = 'text';

        return $response;
    }

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    protected function createExpectedResult($response)
    {
        return (new ArvatoRssRiskCheckResponseTransfer())
            ->setActionCode($response->Decision->ActionCode)
            ->setResultCode($response->Decision->ResultCode)
            ->setResult($response->Decision->Result)
            ->setResultText($response->Decision->ResultText);
    }

}
