<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\ArvatoRss;

use Pyz\Client\ArvatoRss\Zed\ArvatoRssStub;
use Spryker\Client\Kernel\AbstractFactory;

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
