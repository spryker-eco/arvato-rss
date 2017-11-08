<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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