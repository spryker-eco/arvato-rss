<?php

namespace Functional\SprykerEco\Zed\ArvatoRss\Business\Facade;

use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use PHPUnit\Framework\TestCase;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;
use SprykerEco\Zed\ArvatoRss\Business\ArvatoRssBusinessFactory;
use SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacade;

class ArvatoRssFacadeRiskCheckTest extends TestCase
{

    /**
     * @return void
     */
    public function performRiskCheckTest()
    {
        $quoteTransfer = $this->createQuoteTransfer();
        $facade = new ArvatoRssFacade();

        $response = $facade->performRiskCheck($quoteTransfer);
        $expected = $this->createExpectedResult();
        $actual = $response->getArvatoRssRiskCheckResponse();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createFactory()
    {
        $builder = $this->getMockBuilder(ArvatoRssBusinessFactory::class);
        $builder
            ->method('createSoapApiAdapter')
            ->willReturn($this->createSoapApiAdapter());
        $stub = $builder->getMock();

        return $stub;
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    protected function createQuoteTransfer()
    {
        return new QuoteTransfer();
    }

    /**
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    protected function createExpectedResult()
    {
        return (new ArvatoRssRiskCheckResponseTransfer())
            ->setResult('R')
            ->setResultText('text')
            ->setResultCode('aaa')
            ->setActionCode('test');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createSoapApiAdapter()
    {
        $mock = $this->createPartialMock(SoapApiAdapter::class, ['performRiskCheck']);
        $mock
            ->method('performRiskCheck')
            ->willReturn($this->createExpectedResult());
        return $mock;
    }

}
