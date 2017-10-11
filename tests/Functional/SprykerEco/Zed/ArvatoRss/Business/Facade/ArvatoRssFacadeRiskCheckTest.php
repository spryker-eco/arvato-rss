<?php

namespace Functional\SprykerEco\Zed\ArvatoRss\Business\Facade;

use Codeception\TestCase\Test;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use ArvatoRss\Helper\QuoteHelper;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;
use SprykerEco\Zed\ArvatoRss\Business\ArvatoRssBusinessFactory;
use SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacade;
use SprykerEco\Zed\ArvatoRss\Business\Handler\RiskCheckHandlerInterface;

class ArvatoRssFacadeRiskCheckTest extends Test
{

    /**
     * @var \ArvatoRss\Helper\QuoteHelper $quoteHelper
     */
    protected $quoteHelper;

    /**
     * @dataProvider quoteDataProvider
     *
     * @param array $data
     *
     * @return void
     */
    public function testPerformRiskCheck(array $data)
    {
        $facade = new ArvatoRssFacade();
        $facade->setFactory($this->createFactory());
        $quoteTransfer = $this->quoteHelper->createQuoteTransfer($data);
        $response = $facade->performRiskCheck($quoteTransfer);
        $expected = $this->createExpectedResult();
        $actual = $response->getArvatoRssRiskCheckResponse();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @return array
     */
    public function quoteDataProvider()
    {
        $data = [
            [
                [
                    'clientId' => Config::get(ArvatoRssConstants::ARVATORSS_CLIENTID),
                    'authorisation' => Config::get(ArvatoRssConstants::ARVATORSS_AUTHORISATION),
                    'country' => 'DE',
                    'city' => 'Berlin',
                    'street' => 'Europa-Allee 50',
                    'streetNumber' => '17',
                    'zipCode' => '60327',
                    'firstName' => 'Michael',
                    'lastName' => 'Duglas',
                    'salutation' => 'MR',
                    'email' => 'duglas@gmail.com',
                    'phoneNumber' => '123213',
                    'birthDay' => '1978-10-01',
                    'position' => 1,
                    'productNumber' => '777777',
                    'unitPrice' => 12000,
                    'unitCount' => 1,
                    'itemQuantity' => 1,
                    'grandTotal' => 15000,
                    'subTotal' => 14000
                ]
            ]
        ];

        return $data;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createFactory()
    {
        $mock = $this->getMockBuilder(ArvatoRssBusinessFactory::class)
            ->setMethods(['createRiskCheckHandler'])
            ->getMock();
        $mock
            ->expects($this->once())
            ->method('createRiskCheckHandler')
            ->willReturn($this->createRiskCheckHandler());

        return $mock;
    }

    /**
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    protected function createExpectedResult()
    {
        return (new ArvatoRssRiskCheckResponseTransfer())
            ->setResult('R')
            ->setResultCode('AVD999')
            ->setActionCode('O_I')
            ->setResultText('Address invalid invoice');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    protected function createRiskCheckHandler()
    {
        $mock = $this->getMockBuilder(RiskCheckHandlerInterface::class)
            ->setMethods(['performRiskCheck'])
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('performRiskCheck')
            ->willReturn(
                (new QuoteTransfer())
                    ->setArvatoRssRiskCheckResponse($this->createExpectedResult())
            );

        return $mock;
    }

    /**
     * @param \ArvatoRss\Helper\QuoteHelper $quoteHelper
     *
     * @return void
     */
    protected function _inject(QuoteHelper $quoteHelper)
    {
        $this->quoteHelper = $quoteHelper;
    }

}
