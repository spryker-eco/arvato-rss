<?php

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\TestCase;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper;
use \ArrayObject;

//TODO: please, configure project to run tests and check tests.
class RiskCheckResponseMapperTest extends TestCase
{

    /**
     * @dataProvider responseDataProvider
     */
    public function mapResponseToQuoteTest($data)
    {
        $mapper = $this->createMapper();

        $expected = $this->createExpectedTransfer($data)->toArray(true);
        $actual = $mapper->mapResponseToQuote(
            $this->createResponseTransfer($data),
            $this->createQuoteTranfer()
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
                new \ArrayObject(
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
                        'city' => 'Berlin'
                    ]
                )
            ]
        ];
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createQuoteTranfer()
    {
        return new QuoteTransfer();
    }

    /**
     * @param \ArrayObject $data
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createExpectedTransfer(ArrayObject $data)
    {
        $quoteTranfer = $this->createQuoteTranfer();
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
        $transfer->setResult($data->getResult());
        $transfer->setActionCode($data->getActionCode());
        $transfer->setActionCode($data->getActionCode());
        $transfer->setResultText($data->getResultText());

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