<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Facade;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\QuoteBuilder;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEcoTest\Zed\ArvatoRss\Helper\QuoteHelper;
use SprykerTest\Shared\Testify\Helper\ConfigHelper;

class AbstractFacadeTest extends Test
{
    const IS_ERROR = false;
    const RESPONSE_STRING_FIElD_VALUE = 'test';

    protected $quote;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->getModule('\\' . ConfigHelper::class)->setConfig(ArvatoRssConstants::ARVATORSS_CLIENTID, 'test');
        $this->getModule('\\' . ConfigHelper::class)->setConfig(ArvatoRssConstants::ARVATORSS_AUTHORISATION, 'test');
        $this->quote = $this->getModule('\\' . QuoteHelper::class)->createQuoteTransfer();
    }
}
