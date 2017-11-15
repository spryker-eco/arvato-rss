<?php

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;

interface ApiCallInterface
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     * @param array $params
     *
     * @return \stdClass
     */
    public function execute(
        ArvatoRssIdentificationRequestTransfer $identification,
        array $params
    );
}
