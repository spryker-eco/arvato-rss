<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
