<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock;

use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

class MoneyFacadeMock implements ArvatoRssToMoneyInterface
{
    const VALUE_DECIMAL = 100.00;
    const VALUE_INT = 10000;

    /**
     * @param int $value
     *
     * @return float
     */
    public function convertIntegerToDecimal($value)
    {
        return static::VALUE_DECIMAL;
    }

    /**
     * @param float $value
     *
     * @return int
     */
    public function convertDecimalToInteger($value)
    {
        return static::VALUE_INT;
    }
}
