<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use \stdClass;

interface ArvatoRssResponseConverterInterface
{

    /**
     * @param \stdClass $response
     *
     * @return
     */
    public function convert(stdClass $response);

}