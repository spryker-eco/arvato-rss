<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter;

use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactory;

class AdapterFactoryMock extends AdapterFactory
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface
     */
    public function createStoreOrderCall()
    {
        return new StoreOrderCallMock(
            $this->createRequestHeaderConverter(),
            $this->createApiCallLogger()
        );
    }
}