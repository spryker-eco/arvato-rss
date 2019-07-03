<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock;

use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

class MoneyFacadeMock implements ArvatoRssToMoneyInterface
{
    public const VALUE_DECIMAL = 100.00;
    public const VALUE_INT = 10000;

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
