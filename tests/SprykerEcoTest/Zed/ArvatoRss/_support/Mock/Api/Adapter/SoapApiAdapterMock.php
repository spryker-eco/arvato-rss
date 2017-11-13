<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter;

use Generated\Shared\DataBuilder\ArvatoRssRiskCheckResponseBuilder;
use Generated\Shared\DataBuilder\ArvatoRssStoreOrderResponseBuilder;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;

class SoapApiAdapterMock extends SoapApiAdapter
{
    const WSDL_PATH = __DIR__ . "/../../../../../../../../src/SprykerEco/Zed/ArvatoRss/Business/Api/Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        return (new ArvatoRssRiskCheckResponseBuilder())->build()->setIsError(false);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssStoreOrderResponseTransfer
     */
    public function storeOrder(ArvatoRssStoreOrderRequestTransfer $requestTransfer)
    {
        return (new ArvatoRssStoreOrderResponseBuilder())->build()->setIsError(false);
    }
}
