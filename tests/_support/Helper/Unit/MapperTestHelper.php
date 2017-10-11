<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace ArvatoRss\Helper\Unit;

use Codeception\Module;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterService;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapper;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapper;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;

class MapperTestHelper extends Module
{

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface $moneyFacade
     *
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckRequestMapperInterface
     */
    public function createRequestMapper(ArvatoRssToMoneyInterface $moneyFacade)
    {
        return new RiskCheckRequestMapper(
            $moneyFacade,
            $this->createConverter()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\RiskCheckResponseMapperInterface
     */
    public function createResponseMapper()
    {
        return new RiskCheckResponseMapper();
    }

    /**
     * @return \SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface
     */
    public function createConverter()
    {
        return new Iso3166ConverterService();
    }

}
