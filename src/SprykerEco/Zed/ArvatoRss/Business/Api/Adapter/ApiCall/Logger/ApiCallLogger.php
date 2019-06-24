<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\Logger;

use Generated\Shared\Transfer\ArvatoRssApiCallLogTransfer;
use SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig;
use SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssEntityManagerInterface;
use SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface;
use stdClass;

class ApiCallLogger implements ApiCallLoggerInterface
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
     * @param string $orderReference
     * @param string $type
     * @param string $resultCode
     * @param array $requestPayload
     * @param \stdClass $responsePayload
     *
     * @return void
     */
    public function log(
        $orderReference,
        $type,
        $resultCode,
        array $requestPayload,
        stdClass $responsePayload
    ):void {
        $callLog = (new ArvatoRssApiCallLogTransfer())
            ->setOrderReference($orderReference)
            ->setCallType($type)
            ->setResultCode($resultCode)
            ->setRequestPayload(
                print_r($requestPayload, true)
            )
            ->setResponsePayload(
                print_r($responsePayload, true)
            );

        if (property_exists($responsePayload, ArvatoRssApiConfig::RESPONSE_DECISION)
            && property_exists($responsePayload->Decision, ArvatoRssApiConfig::RESPONSE_COMMUNICATION_TOKEN)
        ) {
            $callLog->setCommunicationToken($responsePayload->Decision->CommunicationToken);
        }

        $this->entityManager->saveArvatoRssApiLogEntity($callLog);
    }

    /**
     * @param string $communicationToken
     * @param string $orderReference
     *
     * @return void
     */
    public function updateLogWithOrderReference(string $communicationToken, string $orderReference): void
    {
        $apiLogTransfer =  $this->repository
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
