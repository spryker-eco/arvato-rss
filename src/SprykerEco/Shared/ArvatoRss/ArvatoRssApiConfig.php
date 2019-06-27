<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Shared\ArvatoRss;

interface ArvatoRssApiConfig
{
    public const RESULT_CODE_SUCCESS = 'SOR000';

    // Payment method types
    public const INVOICE = 'OI';
    public const DIRECT_DEBIT = 'DD';
    public const CREDIT_CARD = 'CC';
    public const INSTALLMENT = 'IP';
    public const CASH_ON_DELIVERY = 'COD';
    public const CASH_IN_ADVANCE = 'AP';
    public const E_PAYMENT = 'EP';
    public const OTHER = 'other';

    //Transaction types
    public const TRANSACTION_TYPE_STORE_ORDER = 'STORE_ORDER';
    public const TRANSACTION_TYPE_RISK_CHECK = 'RISK_CHECK';
}
