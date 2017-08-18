<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\ArvatoRss;

use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \SprykerEco\Client\ArvatoRss\ArvatoRssFactory getFactory()
 */
class ArvatoRssClient extends AbstractClient implements ArvatoRssClientInterface
{

    /**
     * @return \SprykerEco\Client\ArvatoRss\Zed\ArvatoRssStubInterface
     */
    protected function getZedStub()
    {
        return $this->getFactory()->createZedStub();
    }

}
