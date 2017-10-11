<?php

namespace Functional\SprykerEco\Zed\ArvatoRss\Business\Facade;

use Codeception\TestCase\Test;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use ArvatoRss\Helper\QuoteHelper;
use Spryker\Shared\Config\Config;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;
use SprykerEco\Zed\ArvatoRss\Business\ArvatoRssBusinessFactory;
use SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacade;

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
        $builder = $this->getMockBuilder(ArvatoRssBusinessFactory::class);
        $builder
            ->method('createSoapApiAdapter')
            ->willReturn($this->createSoapApiAdapter());
        $stub = $builder->getMock();

        return $stub;
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
    protected function createSoapApiAdapter()
    {
        $mock = $this->createPartialMock(SoapApiAdapter::class, ['performRiskCheck']);
        $mock
            ->method('performRiskCheck')
            ->willReturn($this->createExpectedResult());
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
