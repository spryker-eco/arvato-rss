<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Service\ArvatoRss;

use Spryker\Service\Kernel\AbstractService;

class Iso3166Converter extends AbstractService implements Iso3166ConverterInterface
{

    /**
     * @const string ISO2_KEY
     */
    const ISO2_KEY = 'alpha2';

    /**
     * @const string NUMERIC_KEY
     */
    const NUMERIC_KEY = 'numeric';

    /**
     * @param string $iso2CountryCode
     *
     * @return string
     */
    public function iso2ToNumeric($iso2CountryCode)
    {
        $key = $this->searchArrayIndex($iso2CountryCode, static::ISO2_KEY);
        if ($key !== false) {
            return ArvatoRssServiceConstants::ISO3166[$key][static::NUMERIC_KEY];
        }

        return null;
    }

    /**
     * @param string $iso3166CountryCode
     *
     * @return string
     */
    public function numericToIso2($iso3166CountryCode)
    {
        $key = $this->searchArrayIndex($iso3166CountryCode, static::NUMERIC_KEY);
        if ($key !== false) {
            return ArvatoRssServiceConstants::ISO3166[$key][static::ISO2_KEY];
        }

        return null;
    }

    /**
     * @param string $value
     * @param string $columnName
     *
     * @return string
     */
    protected function searchArrayIndex($value, $columnName)
    {
        return array_search($value, array_column(ArvatoRssServiceConstants::ISO3166, $columnName));
    }

}