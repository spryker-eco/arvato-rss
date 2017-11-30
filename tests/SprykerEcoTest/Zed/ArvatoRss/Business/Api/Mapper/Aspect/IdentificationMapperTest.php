<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;
use SprykerEco\Zed\ArvatoRss\ArvatoRssConfig;
use SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect\IdentificationMapper;
use SprykerEcoTest\Zed\ArvatoRss\Business\AbstractBusinessTest;
use SprykerTest\Shared\Testify\Helper\ConfigHelper;

class IdentificationMapperTest extends AbstractBusinessTest
{
    const CLIENT_ID = 'CLIENT_ID';
    const AUTHORIZATION = 'AUTHORIZATION';

    /**
     * @return void
     */
    public function testMap()
    {
        $this->getModule('\\' . ConfigHelper::class)
            ->setConfig(ArvatoRssConstants::ARVATORSS_CLIENTID, static::CLIENT_ID);
        $this->getModule('\\' . ConfigHelper::class)
            ->setConfig(ArvatoRssConstants::ARVATORSS_AUTHORISATION, static::AUTHORIZATION);
        $mapper = new IdentificationMapper(
            new ArvatoRssConfig()
        );
        $result = $mapper->map();
        $this->testResult($result);
    }

    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $result
     *
     * @return void
     */
    protected function testResult(ArvatoRssIdentificationRequestTransfer $result)
    {
        $this->assertEquals($result->getClientId(), static::CLIENT_ID);
        $this->assertEquals($result->getAuthorisation(), static::AUTHORIZATION);
    }
}
