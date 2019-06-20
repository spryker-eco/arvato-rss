<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Client\ArvatoRss;

use Spryker\Client\Kernel\AbstractFactory;
use SprykerEco\Client\ArvatoRss\Zed\ArvatoRssStub;

class ArvatoRssFactory extends AbstractFactory
{
    /**
     * @return \SprykerEco\Client\ArvatoRss\Zed\ArvatoRssStubInterface
     */
    public function createZedStub()
    {
        return new ArvatoRssStub($this->getZedRequestClient());
    }

    /**
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient()
    {
        return $this->getProvidedDependency(ArvatoRssDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
