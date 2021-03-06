<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock;

use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactoryInterface;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface;
use SprykerEco\Zed\ArvatoRss\Business\ArvatoRssBusinessFactory;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface;
use SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\AdapterFactoryMock;
use SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\SoapApiAdapterMock;

class ArvatoRssBusinessFactoryMock extends ArvatoRssBusinessFactory
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiAdapterInterface
     */
    public function createSoapApiAdapter(): ApiAdapterInterface
    {
        return new SoapApiAdapterMock(
            $this->createAdapterFactory()
        );
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyInterface
     */
    public function getMoneyFacade(): ArvatoRssToMoneyInterface
    {
        return new MoneyFacadeMock();
    }

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactoryInterface
     */
    public function createAdapterFactory(): AdapterFactoryInterface
    {
        return new AdapterFactoryMock();
    }
}
