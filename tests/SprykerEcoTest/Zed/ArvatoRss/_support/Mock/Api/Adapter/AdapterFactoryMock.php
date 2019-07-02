<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter;

use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\AdapterFactory;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface;
use SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\ApiCall\StoreOrderCallMock;

class AdapterFactoryMock extends AdapterFactory
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\ApiCallInterface
     */
    public function createStoreOrderCall(): ApiCallInterface
    {
        return new StoreOrderCallMock(
            $this->createRequestHeaderConverter(),
            $this->createApiCallLogger()
        );
    }
}
