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

class StoreOrderFacadeTest extends AbstractBusinessTest
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->cleanUp();
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
        $this->cleanUp();
    }

    /**
     * @return void
     */
    public function testStoreOrder(): void
    {
        /** @var \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacade $facade */
        $facade = $this->tester->getFacade();
        $facade->setFactory(new ArvatoRssBusinessFactoryMock());
        $facade->storeOrder($this->order);
        $this->test();
    }

    /**
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog|null
     */
    protected function getApiCallLog(): ?SpyArvatoRssApiCallLog
    {
        return SpyArvatoRssApiCallLogQuery::create()->findOne();
    }

    /**
     * @return void
     */
    protected function test(): void
    {
        $apiCallLog = $this->getApiCallLog();
        $this->assertInstanceOf(SpyArvatoRssApiCallLog::class, $apiCallLog);
        $this->assertEquals($apiCallLog->getCallType(), ArvatoRssApiConfig::TRANSACTION_TYPE_STORE_ORDER);
    }
}
