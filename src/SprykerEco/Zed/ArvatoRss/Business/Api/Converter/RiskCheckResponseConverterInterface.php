<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use stdClass;

interface RiskCheckResponseConverterInterface
{

    /**
     * @param \stdClass $response
     *
     * @return void
     */
    public function convert(stdClass $response);

}
