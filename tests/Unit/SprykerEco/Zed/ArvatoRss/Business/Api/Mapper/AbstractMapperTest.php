<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Codeception\TestCase\Test;
use ArvatoRss\Helper\QuoteHelper;
use ArvatoRss\Helper\Unit\MapperTestHelper;

class AbstractMapperTest extends Test
{

    /**
     * @var \ArvatoRss\Helper\Unit\MapperTestHelper $helper
     */
    protected $helper;

    /**
     * @var \ArvatoRss\Helper\QuoteHelper $quoteHelper
     */
    protected $quoteHelper;

    /**
     * @param ArvatoRss\Helper\Unit\MapperTestHelper $mapperHelper
     * @param ArvatoRss\Helper\QuoteHelper $quoteHelper
     *
     * @return void
     */
    protected function _inject(MapperTestHelper $mapperHelper, QuoteHelper $quoteHelper)
    {
        $this->helper = $mapperHelper;
        $this->quoteHelper = $quoteHelper;
    }

}
