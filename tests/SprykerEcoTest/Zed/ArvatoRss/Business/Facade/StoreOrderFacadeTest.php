<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Facade;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;
use SprykerEcoTest\Zed\ArvatoRss\Mock\ArvatoRssBusinessFactoryMock;
use SprykerTest\Shared\Testify\Helper\BusinessHelper;

class StoreOrderFacadeTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->cleanUp();
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        $this->cleanUp();
    }

    /**
     * @return void
     */
    public function testStoreOrder()
    {
        $facade = $this->getModule('\\' . BusinessHelper::class)->getFacade();
        $facade->setFactory(
            new ArvatoRssBusinessFactoryMock()
        );
        $facade->storeOrder($this->order);
        $this->test();
    }

    /**
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog
     */
    protected function getApiCallLog()
    {
        return SpyArvatoRssApiCallLogQuery::create()->findOne();
    }

    /**
     * @return void
     */
    protected function test()
    {
        $apiCallLog = $this->getApiCallLog();
        $this->assertInstanceOf(SpyArvatoRssApiCallLog::class, $apiCallLog);
        $this->assertEquals($apiCallLog->getCallType(), ArvatoRssApiConfig::TRANSACTION_TYPE_STORE_ORDER);
    }

    /**
     * @return void
     */
    protected function cleanUp()
    {
        SpyArvatoRssApiCallLogQuery::create()->deleteAll();
    }
}
