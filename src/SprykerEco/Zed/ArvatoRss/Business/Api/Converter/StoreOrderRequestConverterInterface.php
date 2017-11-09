<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;

interface StoreOrderRequestConverterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer $arvatoRssStoreOrderRequestTransfer
     *
     * @return array
     */
    public function convert(ArvatoRssStoreOrderRequestTransfer $arvatoRssStoreOrderRequestTransfer);
}
