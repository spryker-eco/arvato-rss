<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Handler;

use Generated\Shared\Transfer\ArvatoRssRiskCheckResponseTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Exception\ArvatoRssRiskCheckApiException;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapperInterface;

class RiskCheckHandler implements RiskCheckHandlerInterface
{

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapperInterface $riskCheckRequestMapper
     */
    protected $riskCheckRequestMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapperInterface $riskCheckResponseMapper
     */
    protected $riskCheckResponseMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface $apiAdapter
     */
    protected $apiAdapter;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapperInterface $riskCheckRequestMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapperInterface $riskCheckResponseMapper
     * @param \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface $apiAdapter
     */
    public function __construct(
        RiskCheckRequestMapperInterface $riskCheckRequestMapper,
        RiskCheckResponseMapperInterface $riskCheckResponseMapper,
        ApiAdapterInterface $apiAdapter
    ) {

        $this->riskCheckRequestMapper = $riskCheckRequestMapper;
        $this->riskCheckResponseMapper = $riskCheckResponseMapper;
        $this->apiAdapter = $apiAdapter;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTransfer)
    {
        $requestTransfer = $this->riskCheckRequestMapper->mapQuoteToRequestTranfer($quoteTransfer);
        try {
            $responseTransfer = $this->apiAdapter->performRiskCheck($requestTransfer);
        } catch (ArvatoRssRiskCheckApiException $exception) {
            $responseTransfer = new ArvatoRssRiskCheckResponseTransfer();
        }

        $quoteTransfer = $this->riskCheckResponseMapper->mapResponseToQuote($responseTransfer, $quoteTransfer);

        return $quoteTransfer;
    }

}
