<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter;

use Generated\Shared\DataBuilder\ArvatoRssRiskCheckResponseBuilder;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;

class SoapApiAdapterMock extends SoapApiAdapter
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        return (new ArvatoRssRiskCheckResponseBuilder())->build();
    }
}