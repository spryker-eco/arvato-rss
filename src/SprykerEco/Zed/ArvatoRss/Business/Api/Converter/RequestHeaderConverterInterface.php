<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;

interface RequestHeaderConverterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $arvatoRssRiskCheckRequestTransfer
     *
     * @return \SoapHeader
     */
    public function convert(ArvatoRssIdentificationRequestTransfer $arvatoRssRiskCheckRequestTransfer);
}
