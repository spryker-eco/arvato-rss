<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\ArvatoRssQuoteDataBuilder;
use Generated\Shared\DataBuilder\PaymentBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;

class QuoteHelper extends Module
{
    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function createQuoteTransfer()
    {
        return (new QuoteBuilder())
            ->withArvatoRssQuoteData(
                (new ArvatoRssQuoteDataBuilder())
                    ->withArvatoRssRiskCheckResponse()
                    ->withArvatoRssStoreOrderResponse()
            )
            ->withBillingAddress()
            ->withCustomer()
            ->withTotals()
            ->withCurrency()
            ->withItem()
            ->build()->setPayment(
                (new PaymentBuilder())
                    ->build()
                    ->setPaymentMethod('Invoice')
            );
    }
}
