<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business;

use Codeception\TestCase\Test;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEcoTest\Zed\ArvatoRss\Helper\QuoteHelper;
use SprykerTest\Shared\Testify\Helper\ConfigHelper;

class AbstractBusinessTest extends Test
{
    const RESPONSE_STRING_FIELD_VALUE = 'test';

    /**
     * @var \Generated\Shared\Transfer\QuoteTransfer
     */
    protected $quote;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->getModule('\\' . ConfigHelper::class)->setConfig(ArvatoRssConstants::ARVATORSS_CLIENTID, 'test');
        $this->getModule('\\' . ConfigHelper::class)->setConfig(ArvatoRssConstants::ARVATORSS_AUTHORISATION, 'test');
        $this->getModule('\\' . ConfigHelper::class)->setConfig(ArvatoRssConstants::ARVATORSS_PAYMENT_TYPE_MAPPING, [
            'Invoice' => ArvatoRssApiConfig::INVOICE,
        ]);
        $this->quote = $this->getModule('\\' . QuoteHelper::class)->createQuoteTransfer();
    }
}
