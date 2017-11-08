<?php
namespace ArvatoRss\Helper;

use Codeception\Module;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Generated\Shared\Transfer\TotalsTransfer;

class QuoteHelper extends Module
{
    /**
     * @param array|null $data
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function createQuoteTransfer(array $data = null)
    {
        $quoteTransfer = new QuoteTransfer();
        if ($data) {
            $customerTranfer = new CustomerTransfer();
            $billingAddress = new AddressTransfer();
            $orderItem = new ItemTransfer();

            $billingAddress->setIso2Code($data['country']);
            $billingAddress->setCity($data['city']);
            $billingAddress->setAddress1($data['street']);
            $billingAddress->setAddress2($data['streetNumber']);
            $billingAddress->setZipCode($data['zipCode']);
            $billingAddress->setFirstName($data['firstName']);
            $billingAddress->setLastName($data['lastName']);
            $billingAddress->setPhone($data['phoneNumber']);

            $customerTranfer->setSalutation($data['salutation']);
            $customerTranfer->setEmail($data['email']);
            $customerTranfer->setDateOfBirth($data['birthDay']);

            $orderItem->setUnitPrice($data['unitPrice']);
            $orderItem->setSku($data['productNumber']);
            $orderItem->setQuantity($data['itemQuantity']);

            $quoteTransfer->setCustomer($customerTranfer);
            $quoteTransfer->setBillingAddress($billingAddress);
            $quoteTransfer->addItem($orderItem);

            $quoteTransfer->setTotals(
                (new TotalsTransfer())
                    ->setGrandTotal($data['grandTotal'])
                    ->setSubtotal($data['subTotal'])
            );
        }

        return $quoteTransfer;
    }
}
