<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock;

use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

class MoneyFacadeMock implements ArvatoRssToMoneyInterface
{
    const DECIMAL_VALUE = 100.00;
    const INT_VALUE = 10000;

    /**
     * @param int $value
     *
     * @return float
     */
    public function convertIntegerToDecimal($value)
    {
        return static::DECIMAL_VALUE;
    }

    /**
     * @param float $value
     *
     * @return int
     */
    public function convertDecimalToInteger($value)
    {
        return static::INT_VALUE;
    }
}