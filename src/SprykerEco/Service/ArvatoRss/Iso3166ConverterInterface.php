<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Service\ArvatoRss;

interface Iso3166ConverterInterface
{

    /**
     * @param string $iso2CountryCode
     *
     * @return string|null
     */
    public function iso2ToNumeric($iso2CountryCode);

    /**
     * @param int $iso3166CountryCode
     *
     * @return string|null
     */
    public function numericToIso2($iso3166CountryCode);

}