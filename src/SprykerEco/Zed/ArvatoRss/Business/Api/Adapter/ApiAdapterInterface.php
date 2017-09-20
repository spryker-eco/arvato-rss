<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;

interface ApiAdapterInterface
{

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer);

}
