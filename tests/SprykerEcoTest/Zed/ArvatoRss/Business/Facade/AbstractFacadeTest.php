<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Facade;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\QuoteBuilder;
use Generated\Shared\Transfer\ArvatoRssQuoteDataTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEcoTest\Zed\ArvatoRss\Mock\ArvatoRssBusinessFactoryMock;
use SprykerTest\Shared\Testify\Helper\BusinessHelper;
use SprykerTest\Shared\Testify\Helper\ConfigHelper;

class AbstractTest extends Test
{
    const IS_ERROR = false;
    const RESPONSE_STRING_FIElD_VALUE = 'test';

    public function setUp()
    {
        parent::setUp();
        $this->getModule('\\' . ConfigHelper::class)->setConfig(ArvatoRssConstants::ARVATORSS_CLIENTID, 'test');
        $this->getModule('\\' . ConfigHelper::class)->setConfig(ArvatoRssConstants::ARVATORSS_AUTHORISATION, 'test');
    }

    /**
     * @return QuoteTransfer|\Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    protected function getQuoteTransfer()
    {
        return (new QuoteBuilder())
            ->withBillingAddress()
            ->withCustomer()
            ->withTotals()
            ->withItem()
            ->build();
    }
}
