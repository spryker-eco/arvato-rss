<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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