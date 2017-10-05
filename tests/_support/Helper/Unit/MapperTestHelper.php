<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Helper\Unit;

use ArrayObject;
use Codeception\Module;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;
use SprykerEco\Service\ArvatoRss\Iso3166Converter;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper;

class MapperTestHelper extends Module
{

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper
     */
    public function createRequestMapper($moneyFacade)
    {
        return new RiskCheckRequestMapper(
            $moneyFacade,
            $this->createConverter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper
     */
    public function createResponseMapper()
    {
        return new RiskCheckResponseMapper();
    }

    /**
     * @return \SprykerEco\Service\ArvatoRss\Iso3166Converter
     */
    public function createConverter()
    {
        return new Iso3166Converter();
    }

}
