<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\ArvatoRssQuoteDataBuilder;
use Generated\Shared\DataBuilder\OrderBuilder;
use Generated\Shared\DataBuilder\PaymentBuilder;
use Generated\Shared\DataBuilder\QuoteBuilder;

class SalesHelper extends Module
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
            )
            ->withBillingAddress()
            ->withCustomer()
            ->withTotals()
            ->withCurrency()
            ->withItem()
            ->build()->setPayment(
                (new PaymentBuilder())
                    ->build()
                    ->setPaymentMethod('invoice')
            );
    }

    /**
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function createOrderTransfer()
    {
        return (new OrderBuilder())
            ->withBillingAddress()
            ->withTotals()
            ->withCustomer()
            ->withItem()
            ->withCurrency()
            ->build()->addPayment(
                (new PaymentBuilder())
                    ->build()
                    ->setPaymentMethod('invoice')
            );
    }
}
