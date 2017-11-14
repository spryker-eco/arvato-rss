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
    public function convert(stdClass $outcome)
    {
        $response = new ArvatoRssStoreOrderResponseTransfer();
        $response->setTransactionId($outcome->System->TransactionId)
            ->setStatusCode($outcome->System->StatusCode)
            ->setResult($outcome->Decision->Result)
            ->setActionCode($outcome->Decision->ActionCode)
            ->setResultCode($outcome->Decision->ResultCode)
            ->setResultText($outcome->Decision->ResultText)
            ->setIsNewCustomer($outcome->Decision->IsNewCustomer);

        return $response;
    }
}
