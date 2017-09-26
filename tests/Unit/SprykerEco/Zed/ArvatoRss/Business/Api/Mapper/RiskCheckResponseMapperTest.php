<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper;

class RiskCheckResponseMapperTest extends AbstractMapperTest
{

    /**
     * @dataProvider responseDataProvider
     *
     * @param \ArrayObject $data
     *
     * @return void
     */
    public function testMapResponseToQuote($data)
    {
        $mapper = $this->createMapper();

        $expected = $this->createExpectedTransfer($data)->toArray(true);
        $actual = $mapper->mapResponseToQuote(
            $this->createResponseTransfer($data),
            $this->helper->createQuoteTransfer()
        )->toArray(true);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function responseDataProvider()
    {
        return [
            [
                new ArrayObject(
                    [
                        'result' => 'R',
                        'resultCode' => 'R',
                        'actionCode' => 'IPT999',
                        'resultText' => 'Test',
                        'scoreValue' => '12',
                        'scoreFeatureName' => 'Test',
                        'scoreFeatuteValue' => 'Test',
                        'rmfCustomerId' => '123',
                        'isNewCustomer' => true,
                        'communicationToken' => '123123',
                        'returnCode' => '0',
                        'street' => 'Europa-Allee 50',
                        'streetNumber' => '12',
                        'zipCode' => '12312',
                        'city' => 'Berlin',
                    ],
                    ArrayObject::ARRAY_AS_PROPS
                )
            ],
        ];
    }

    /**
     * @param \ArrayObject $data
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createExpectedTransfer(ArrayObject $data)
    {
        $quoteTranfer = $this->helper->createQuoteTransfer();
        $responseTransfer = $this->createResponseTransfer($data);
        $quoteTranfer->setArvatoRssRiskCheckResponse($responseTransfer);

        return $quoteTranfer;
    }

    /**
     * @param \ArrayObject $data
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    protected function createResponseTransfer(ArrayObject $data)
    {
        $transfer = new ArvatoRssRiskCheckResponseTransfer();
        $transfer->setResult($data->result);
        $transfer->setActionCode($data->actionCode);
        $transfer->setResultCode($data->resultCode);
        $transfer->setResultText($data->resultText);

        return $transfer;
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper
     */
    protected function createMapper()
    {
        return new RiskCheckResponseMapper();
    }

}
