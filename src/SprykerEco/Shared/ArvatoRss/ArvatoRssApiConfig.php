<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\ArvatoRss;

interface ArvatoRssApiConfig
{
    const RESULT_CODE_SUCCESS = 'SOR000';

    // Payment method types
    const INVOICE = 'OI';
    const DIRECT_DEBIT = 'DD';
    const CREDIT_CARD = 'CC';
    const INSTALLMENT = 'IP';
    const CASH_ON_DELIVERY = 'COD';
    const CASH_IN_ADVANCE = 'AP';
    const E_PAYMENT = 'EP';
    const OTHER = 'other';

    //Transaction types
    const TRANSACTION_TYPE_STORE_ORDER = 'STORE_ORDER';
    const TRANSACTION_TYPE_RISK_CHECK = 'RISK_CHECK';
}
