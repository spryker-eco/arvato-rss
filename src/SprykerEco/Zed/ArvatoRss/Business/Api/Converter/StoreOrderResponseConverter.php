<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Converter;

use Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer;
use stdClass;

class StoreOrderResponseConverter implements StoreOrderResponseConverterInterface
{
    /**
     * @param \stdClass $outcome
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
