<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Unit\SprykerEco\Zed\ArvatoRss\Business\Api\Mapper;

use Helper\Unit\MapperTestHelper;
use PHPUnit\Framework\TestCase;

class AbstractMapperTest extends TestCase
{

    /**
     * @var \Helper\Unit\MapperTestHelper $helper
     */
    protected $helper;

    /**
     * @param \Helper\Unit\MapperTestHelper $mapperHelper
     *
     * @return void
     */
    protected function _inject(MapperTestHelper $mapperHelper)
    {
        $this->helper = $mapperHelper;
    }

}