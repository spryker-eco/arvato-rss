<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\ArvatoRss;

use Spryker\Service\Kernel\AbstractService;
use SprykerEco\Shared\ArvatoRss\ArvatoRssCountryConfig;

class Iso3166ConverterService extends AbstractService implements Iso3166ConverterServiceInterface
{
    public const ISO2_KEY = 'alpha2';
    public const ISO3166_KEY = 'numeric';

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $iso2CountryCode
     *
     * @return string|null
     */
    public function iso2ToNumeric($iso2CountryCode)
    {
        $key = $this->searchArrayIndex($iso2CountryCode, static::ISO2_KEY);
        if ($key !== false) {
            return ArvatoRssCountryConfig::ISO3166[$key][static::ISO3166_KEY];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $iso3166CountryCode
     *
     * @return string|null
     */
    public function numericToIso2($iso3166CountryCode)
    {
        $key = $this->searchArrayIndex($iso3166CountryCode, static::ISO3166_KEY);
        if ($key !== false) {
            return ArvatoRssCountryConfig::ISO3166[$key][static::ISO2_KEY];
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
        return array_search($value, array_column(ArvatoRssCountryConfig::ISO3166, $columnName));
    }
}
