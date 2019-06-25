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
    protected const TEST_ORDER_REFERENCE = 'TEST--DE--1';

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
            ->withShippingAddress()
            ->withCustomer()
            ->withTotals()
            ->withCurrency()
            ->withItem()
            ->build()
            ->setPayment(
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
            ->withShippingAddress()
            ->withTotals()
            ->withCustomer()
            ->withItem()
            ->withCurrency()
            ->build()
            ->addPayment(
                (new PaymentBuilder())
                    ->build()
                    ->setPaymentMethod('invoice')
            )
            ->setOrderReference(static::TEST_ORDER_REFERENCE);
    }
}
