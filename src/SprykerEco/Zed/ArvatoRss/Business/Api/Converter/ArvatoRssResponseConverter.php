<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use \stdClass;

class ArvatoRssResponseConverter implements ArvatoRssResponseConverterInterface
{

    /**
     * @param \stdClass $response
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function convert(stdClass $response)
    {
        $responseTransfer = new ArvatoRssRiskCheckResponseTransfer();

        $responseTransfer->setResult($response->Decision->Result);
        $responseTransfer->setResultCode($response->Decision->ResultCode);
        $responseTransfer->setActionCode($response->Decision->ActionCode);
        $responseTransfer->setIsNewCustomer($response->Decision->IsNewCustomer);

        return $responseTransfer;
    }

}