<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

interface ArvatoRssResponseConverterInterface
{

    /**
     * @param array $response
     */
    public function convert(array $response);

}