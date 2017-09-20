<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;

use Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter;

class SoapApiAdapter implements ApiAdapterInterface
{

    /**
     * @const WSDL_PATH
     */
    const WSDL_PATH = __DIR__."/../Etc/risk-solution-services.v2.1.wsdl";

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter
     */
    protected $riskCheckRequestConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter
     */
    protected $riskCheckRequestHeaderConverter;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter
     */
    protected $riskCheckResponseConverter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverter $riskCheckRequestConverter
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestHeaderConverter $riskCheckRequestHeaderConverter
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckResponseConverter $riskCheckResponseConverter
     */
    public function __construct(
        RiskCheckRequestConverter $riskCheckRequestConverter,
        RiskCheckRequestHeaderConverter $riskCheckRequestHeaderConverter,
        RiskCheckResponseConverter $riskCheckResponseConverter
    )
    {
        $this->riskCheckRequestConverter = $riskCheckRequestConverter;
        $this->riskCheckRequestHeaderConverter = $riskCheckRequestHeaderConverter;
        $this->riskCheckResponseConverter = $riskCheckResponseConverter;
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssRiskCheckRequestTransfer $requestTransfers
     *
     * @return \Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer
     */
    public function performRiskCheck(ArvatoRssRiskCheckRequestTransfer $requestTransfer)
    {
        $params = $this->riskCheckRequestConverter->convert($requestTransfer);
        $header = $this->riskCheckRequestHeaderConverter->convert($requestTransfer);
        $options = [];
        $soapClient = new \SoapClient(static::WSDL_PATH, $options);
        $soapClient->__setSoapHeaders($header);
        $result = $soapClient->RiskCheck($params);

        return $this->riskCheckResponseConverter->convert($result);
    }

}