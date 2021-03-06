<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Handler;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapperInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapperInterface;

class RiskCheckHandler implements RiskCheckHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapperInterface
     */
    protected $riskCheckRequestMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapperInterface
     */
    protected $riskCheckResponseMapper;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface
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
        $responseTransfer = $this->apiAdapter->performRiskCheck($requestTransfer);
        $quoteTransfer = $this->riskCheckResponseMapper->mapResponseToQuote($responseTransfer, $quoteTransfer);

        return $quoteTransfer;
    }
}
