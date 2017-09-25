<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Helper\Unit;

use ArrayObject;
use Codeception\Module;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;

class MapperTestHelper extends Module
{

    /**
     * @param \ArrayObject|null $data
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function createQuoteTransfer(ArrayObject $data = null)
    {
        $quoteTransfer = new QuoteTransfer();
        if ($data) {
            $customerTranfer = new CustomerTransfer();
            $billingAddress = new AddressTransfer();
            $orderItem = new ItemTransfer();

            $billingAddress->setIso2Code($data->getCountry());
            $billingAddress->setCity($data->getCity());
            $billingAddress->setAddress1($data->getStreet());
            $billingAddress->setZipCode($data->getZipCode());

            $customerTranfer->setFirstName($data->getFirstName());
            $customerTranfer->setLastName($data->getLastName());
            $customerTranfer->setSalutation($data->getSalutation());
            $customerTranfer->setEmail($data->getEmail());
            $customerTranfer->setPhone($data->getPhoneNumber());
            $customerTranfer->setDateOfBirth($data->getBirthDay());

            $orderItem->setUnitPrice($data->getUnitPrice());
            $orderItem->setSku($data->getProductNumber());

            $quoteTransfer->setCustomer($customerTranfer);
            $quoteTransfer->setBillingAddress($billingAddress);
            $quoteTransfer->addItem($orderItem);
        }

        return $quoteTransfer;
    }

    /**
     * @return void
     */
    public function createRequestMapper()
    {
    }

    /**
     * @return void
     */
    public function createResponseMapper()
    {
    }

}
