<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Service\ArvatoRss;

interface Iso3166ConverterServiceInterface
{
    /**
     * Converts ISO2 code to ISO3166.
     *
     * @api
     *
     * @param string $iso2CountryCode
     *
     * @return string|null
     */
    public function iso2ToNumeric($iso2CountryCode);

    /**
     * Converts ISO3166 to ISO2.
     *
     * @api
     *
     * @param int $iso3166CountryCode
     *
     * @return string|null
     */
    public function numericToIso2($iso3166CountryCode);
}
