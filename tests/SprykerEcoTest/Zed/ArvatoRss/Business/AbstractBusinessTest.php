<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business;

use Codeception\TestCase\Test;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;

class AbstractBusinessTest extends Test
{
    protected const RESPONSE_STRING_FIELD_VALUE = 'test';

    /**
     * @var \SprykerEcoTest\Zed\ArvatoRss\ArvatoRssZedTester
     */
    protected $tester;

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quote;

    /**
     * @var \Generated\Shared\Transfer\OrderTransfer
     */
    protected $order;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->tester->setConfig(ArvatoRssConstants::ARVATORSS_CLIENTID, 'test');
        $this->tester->setConfig(ArvatoRssConstants::ARVATORSS_AUTHORISATION, 'test');
        $this->tester->setConfig(ArvatoRssConstants::ARVATORSS_PAYMENT_TYPE_MAPPING, [
            'invoice' => ArvatoRssApiConfig::INVOICE,
        ]);
        $this->quote = $this->tester->createQuoteTransfer();
        $this->order = $this->tester->createOrderTransfer();
    }

    /**
     * @return void
     */
    protected function cleanUp(): void
    {
        SpyArvatoRssApiCallLogQuery::create()->deleteAll();
    }
}
