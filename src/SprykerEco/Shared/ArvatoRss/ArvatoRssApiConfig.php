<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
