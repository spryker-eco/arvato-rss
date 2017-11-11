<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Codeception\TestCase\Test;
use SprykerEcoTest\Zed\ArvatoRss\Helper\QuoteHelper;

class AbstractMapperTest extends Test
{
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
        $this->quote = $this->getModule('\\' . QuoteHelper::class)->createQuoteTransfer();
    }
}
