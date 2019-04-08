<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use stdClass;

interface StoreOrderResponseConverterInterface
{
    /**
     * @param \stdClass $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer
     */
    public function convert(stdClass $response);
}
