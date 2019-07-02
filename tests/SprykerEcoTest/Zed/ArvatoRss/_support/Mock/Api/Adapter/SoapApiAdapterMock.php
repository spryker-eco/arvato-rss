<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter;

use Generated\Shared\DataBuilder\ArvatoRssRiskCheckResponseBuilder;
use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\SoapApiAdapter;

class SoapApiAdapterMock extends SoapApiAdapter
{
    public const WSDL_PATH = __DIR__ . "/../../../../../../../../src/SprykerEco/Zed/ArvatoRss/Business/Api/Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        return (new ArvatoRssRiskCheckResponseBuilder())->build()->setIsError(false);
    }
}
