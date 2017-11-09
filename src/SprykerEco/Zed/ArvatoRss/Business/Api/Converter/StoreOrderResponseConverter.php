<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use stdClass;

class StoreOrderResponseConverter implements StoreOrderResponseConverterInterface
{
    /**
     * @param \stdClass $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer
     */
    public function convert(stdClass $response)
    {
        return new ArvatoRssStoreOrderResponseTransfer();
    }
}
