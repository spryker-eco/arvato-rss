<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\ArvatoRss;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \SprykerEco\Client\ArvatoRss\ArvatoRssFactory getFactory()
 */
class ArvatoRssClient extends AbstractClient implements ArvatoRssClientInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function performRiskCheck(QuoteTransfer $quoteTransfer)
    {
        return $this->getFactory()->createZedStub()->performRiskCheck($quoteTransfer);
    }
}
