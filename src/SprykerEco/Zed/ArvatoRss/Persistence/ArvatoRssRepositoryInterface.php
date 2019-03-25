<?php

namespace SprykerEco\Zed\ArvatoRss\Persistence;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;

interface ArvatoRssRepositoryInterface
{
    /**
     * @param string $orderReference
     * @param string $type
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer|null
     */
    public function findApiLogByOrderReferenceAndType(string $orderReference, string $type): ?ArvatoRssApiCallLogTransfer;
}