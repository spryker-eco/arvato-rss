<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\ArvatoRss;

interface ArvatoRssPaymentTypeConstants
{
    const INVOICE = 'OI';
    const DIRECT_DEBIT = 'DD';
    const CREDIT_CARD = 'CC';
    const INSTALLMENT = 'IP';
    const CASH_ON_DELIVERY = 'COD';
    const CASH_IN_ADVANCE = 'AP';
    const E_PAYMENT = 'EP';
    const OTHER = 'other';
}