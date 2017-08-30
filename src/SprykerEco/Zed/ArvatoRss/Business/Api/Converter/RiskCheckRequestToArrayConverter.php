<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;

//TODO: implement interface
class RiskCheckRequestToArrayConverter
{

    /**
     * @param ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer
     *
     * @return array
     */
    public function convert(ArvatoRssRiskCheckRequestTransfer $arvatoRssRiskCheckRequestTransfer)
    {
        $transferData = $arvatoRssRiskCheckRequestTransfer->toArray(false);
        $preparedData = [];
        foreach ($transferData as $key => $value) {
            $preparedData[ucfirst($key)] = $value;
        }

        return $preparedData;
    }

}