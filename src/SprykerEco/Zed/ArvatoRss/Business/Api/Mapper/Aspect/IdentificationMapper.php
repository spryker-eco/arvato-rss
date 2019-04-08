<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use SprykerEco\Zed\ArvatoRss\ArvatoRssConfig;

class IdentificationMapper implements IdentificationMapperInterface
{
    /**
     * @var \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig
     */
    protected $config;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig $config
     */
    public function __construct(ArvatoRssConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @api
     *
     * @return \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer
     */
    public function map()
    {
        $identificationTransfer = new ArvatoRssIdentificationRequestTransfer();

        $identificationTransfer->setClientId(
            $this->config->getClientId()
        );
        $identificationTransfer->setAuthorisation(
            $this->config->getAuthorization()
        );

        return $identificationTransfer;
    }
}
