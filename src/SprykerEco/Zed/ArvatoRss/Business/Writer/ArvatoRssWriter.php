<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Writer;

use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssEntityManagerInterface;
use SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface;

class ArvatoRssWriter implements ArvatoRssWriterInterface
{
    /**
     * @var \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface
     */
    protected $repository;

    /**
     * @var \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface $repository
     * @param \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssEntityManagerInterface $entityManager
     */
    public function __construct(
        ArvatoRssRepositoryInterface $repository,
        ArvatoRssEntityManagerInterface $entityManager
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $communicationToken
     * @param string $orderReference
     *
     * @return void
     */
    public function updateLogWithOrderReference(string $communicationToken, string $orderReference): void
    {
        $apiLogTransfer = $this->repository
            ->findApiLogByCommunicationTokenAndType(
                $communicationToken,
                ArvatoRssApiConfig::TRANSACTION_TYPE_RISK_CHECK
            );

        if ($apiLogTransfer === null) {
            return;
        }

        $apiLogTransfer->setOrderReference($orderReference);

        $this->entityManager->updateArvatoRssApiLogEntity($apiLogTransfer);
    }
}
