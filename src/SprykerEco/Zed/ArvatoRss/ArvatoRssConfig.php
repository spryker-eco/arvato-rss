<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;

class ArvatoRssConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->get(ArvatoRssConstants::ARVATORSS_CLIENTID);
    }

    /**
     * @return string
     */
    public function getAuthorization()
    {
        return $this->get(ArvatoRssConstants::ARVATORSS_AUTHORISATION);
    }
}
