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
use SprykerEco\Service\ArvatoRss\Iso3166Converter;

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

            $billingAddress->setIso2Code($data->country);
            $billingAddress->setCity($data->city);
            $billingAddress->setAddress1($data->street);
            $billingAddress->setZipCode($data->zipCode);

            $customerTranfer->setFirstName($data->firstName);
            $customerTranfer->setLastName($data->lastName);
            $customerTranfer->setSalutation($data->salutation);
            $customerTranfer->setEmail($data->email);
            $customerTranfer->setPhone($data->phoneNumber);
            $customerTranfer->setDateOfBirth($data->birthDay);

            $orderItem->setUnitPrice($data->unitPrice);
            $orderItem->setSku($data->productNumber);

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

    /**
     * @return \SprykerEco\Service\ArvatoRss\Iso3166Converter
     */
    public function createConverter()
    {
        return new Iso3166Converter();
    }

}
