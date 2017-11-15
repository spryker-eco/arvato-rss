<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock;

use SprykerEco\Zed\ArvatoRss\Business\ArvatoRssBusinessFactory;
use SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\AdapterFactoryMock;
use SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\SoapApiAdapterMock;

class ArvatoRssBusinessFactoryMock extends ArvatoRssBusinessFactory
{
    /**
     * @return \SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\SoapApiAdapterMock
     */
    protected function createSoapApiAdapter()
    {
        return new SoapApiAdapterMock(
            $this->createAdapterFactory()
        );
    }

    /**
     * @return \SprykerEcoTest\Zed\ArvatoRss\Mock\MoneyFacadeMock
     */
    protected function getMoneyFacade()
    {
        return new MoneyFacadeMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\AdapterFactoryMock
     */
    protected function createAdapterFactory()
    {
        return new AdapterFactoryMock();
    }
}
