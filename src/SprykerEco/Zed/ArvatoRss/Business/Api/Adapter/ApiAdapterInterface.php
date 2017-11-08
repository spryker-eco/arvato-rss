<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;

interface ApiAdapterInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer);

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     * @param array $requestParameters
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer
     */
    public function storeOrder(
        ArvatoRssIdentificationRequestTransfer $identification,
        array $requestParameters
    );
}
