<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Codeception\TestCase\Test;
use Helper\QuoteHelper;
use Helper\Unit\MapperTestHelper;

class AbstractMapperTest extends Test
{

    /**
     * @var \Helper\Unit\MapperTestHelper $helper
     */
    protected $helper;

    /**
     * @var \Helper\QuoteHelper $quoteHelper
     */
    protected $quoteHelper;

    /**
     * @param \Helper\Unit\MapperTestHelper $mapperHelper
     * @param \Helper\QuoteHelper $quoteHelper
     *
     * @return void
     */
    protected function _inject(MapperTestHelper $mapperHelper, QuoteHelper $quoteHelper)
    {
        $this->helper = $mapperHelper;
        $this->quoteHelper = $quoteHelper;
    }

}
