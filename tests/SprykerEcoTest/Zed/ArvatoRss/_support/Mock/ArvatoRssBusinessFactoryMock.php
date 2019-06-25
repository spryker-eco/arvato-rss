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
    public function createSoapApiAdapter()
    {
        return new SoapApiAdapterMock(
            $this->createAdapterFactory()
        );
    }

    /**
     * @return \SprykerEcoTest\Zed\ArvatoRss\Mock\MoneyFacadeMock
     */
    public function getMoneyFacade()
    {
        return new MoneyFacadeMock();
    }

    /**
     * @return \SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\AdapterFactoryMock
     */
    public function createAdapterFactory()
    {
        return new AdapterFactoryMock();
    }
}
