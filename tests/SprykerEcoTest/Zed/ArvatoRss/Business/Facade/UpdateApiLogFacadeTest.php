<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Facade;

use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog;
use Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLogQuery;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;
use SprykerEcoTest\Zed\ArvatoRss\Mock\ArvatoRssBusinessFactoryMock;

class UpdateApiLogFacadeTest extends AbstractBusinessTest
{
    protected const TEST_ORDER_REFERENCE = 'TEST--DE--1';
    protected const TEST_COMMUNICATION_TOKEN = 'TEST--COMMUNICATION--TOKEN';
    protected const TEST_CALL_TYPE = 'RISK_CHECK';
    protected const TEST_REQUEST_PAYLOAD = 'request payload';
    protected const TEST_RESPONSE_PAYLOAD = 'response payload';
    protected const TEST_RESULT_CODE = 'OK';

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->cleanUp();
        $this->createApiLog();
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
    public function testPerformRiskCheck(): void
    {
        /** @var \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacade $facade */
        $facade = $this->tester->getFacade();
        $facade->setFactory(new ArvatoRssBusinessFactoryMock());
        $facade->updateApiLogWithOrderReference(
            static::TEST_COMMUNICATION_TOKEN,
            static::TEST_ORDER_REFERENCE
        );
        $this->test();
    }

    /**
     * @return void
     */
    protected function test(): void
    {
        $apiCallLog = $this->getApiCallLog();
        $this->assertInstanceOf(SpyArvatoRssApiCallLog::class, $apiCallLog);
        $this->assertEquals($apiCallLog->getOrderReference(), static::TEST_ORDER_REFERENCE);
    }

    /**
     * @return \Orm\Zed\ArvatoRss\Persistence\SpyArvatoRssApiCallLog|null
     */
    protected function getApiCallLog(): ?SpyArvatoRssApiCallLog
    {
        return SpyArvatoRssApiCallLogQuery::create()
            ->filterByCommunicationToken(static::TEST_COMMUNICATION_TOKEN)
            ->filterByCallType(static::TEST_CALL_TYPE)
            ->findOne();
    }

    /**
     * @return void
     */
    protected function createApiLog(): void
    {
        $apiLogEntity = (new SpyArvatoRssApiCallLog())
            ->setCommunicationToken(static::TEST_COMMUNICATION_TOKEN)
            ->setCallType(static::TEST_CALL_TYPE)
            ->setRequestPayload(static::TEST_REQUEST_PAYLOAD)
            ->setResponsePayload(static::TEST_RESPONSE_PAYLOAD)
            ->setResultCode(static::TEST_RESULT_CODE);

        $apiLogEntity->save();
    }
}
