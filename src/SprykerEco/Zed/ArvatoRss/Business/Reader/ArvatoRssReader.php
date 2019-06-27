<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Reader;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface;

class ArvatoRssReader implements ArvatoRssReaderInterface
{
    /**
     * @var \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface
     */
    protected $repository;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface $repository
     */
    public function __construct(ArvatoRssRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $reference
     * @param string $callType
     *
     * @return \Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer
     */
    public function getApiLogByOrderReferenceAndType(string $reference, string $callType): ArvatoRssApiCallLogTransfer
    {
        $apiLog = $this->repository->findApiLogByOrderReferenceAndType($reference, $callType);

        if ($apiLog === null) {
            return new ArvatoRssApiCallLogTransfer();
        }

        return $apiLog;
    }
}
