<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Facade;

use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;
use SprykerEcoTest\Zed\ArvatoRss\Mock\ArvatoRssBusinessFactoryMock;

class UpdateApiLogFacadeTest extends AbstractBusinessTest
{
    protected const TEST_ORDER_REFERENCE = 'TEST--DE--1';

    /**
     * @return void
     */
    public function testPerformRiskCheck()
    {
        /** @var \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacade $facade */
        $facade = $this->tester->getFacade();
        $facade->setFactory(new ArvatoRssBusinessFactoryMock());
        $facade->updateApiLog('token', 'reference');
        $this->testResponse();
    }

    /**
     * @return void
     */
    protected function testResponse()
    {
    }
}
