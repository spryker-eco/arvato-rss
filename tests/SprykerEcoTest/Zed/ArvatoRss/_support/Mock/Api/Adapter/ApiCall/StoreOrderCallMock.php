<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Mock\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\Adapter\ApiCall\StoreOrderCall;
use stdClass;

class StoreOrderCallMock extends StoreOrderCall
{
    /**
     * @param \Generated\Shared\Transfer\ArvatoRssIdentificationRequestTransfer $identification
     * @param array $params
     *
     * @return \SoapFault|\stdClass
     */
    protected function sendRequest(
        ArvatoRssIdentificationRequestTransfer $identification,
        array $params
    ) {
        $result = new stdClass();
        $decision = new stdClass();
        $system = new stdClass();

        $decision->Result = 'test';
        $decision->ActionCode = 'test';
        $decision->ResultCode = 'test';
        $decision->ResultText = 'test';
        $decision->IsNewCustomer = true;

        $system->TransactionId = '000000000000';
        $system->StatusCode = 'test';

        $result->Decision = $decision;
        $result->System = $system;

        return $result;
    }
}
