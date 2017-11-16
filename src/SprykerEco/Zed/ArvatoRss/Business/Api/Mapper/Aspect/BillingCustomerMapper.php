<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use DateTime;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\BillingCustomerMapperTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface;

class BillingCustomerMapper implements BillingCustomerMapperInterface
{
    /**
     * @var \SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface
     */
    protected $iso3166Converter;

    /**
     * @param \SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface $iso3166Converter
     */
    public function __construct(
        Iso3166ConverterServiceInterface $iso3166Converter
    ) {
        $this->iso3166Converter = $iso3166Converter;
    }

    /**
     * @param \Generated\Shared\Transfer\BillingCustomerMapperTransfer $billingCustomerMapperTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer
     */
    public function map(BillingCustomerMapperTransfer $billingCustomerMapperTransfer)
    {
        $billingCustomerTransfer = new ArvatoRssBillingCustomerTransfer();
        $billingAddress = $billingCustomerMapperTransfer->getBillingAddress();
        $address = $this->prepareAddressTransfer($billingAddress);
        $billingCustomerTransfer->setAddress($address);
        $billingCustomerTransfer->setFirstName($billingAddress->getFirstName());
        $billingCustomerTransfer->setLastName($billingAddress->getLastName());
        $billingCustomerTransfer->setSalutation(strtoupper($billingCustomerMapperTransfer->getSalutation()));
        $billingCustomerTransfer->setEmail($billingCustomerMapperTransfer->getEmail());
        $billingCustomerTransfer->setTelephoneNumber($billingAddress->getPhone());

        return $billingCustomerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $billingAddress
     *
     * @return \Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer
     */
    protected function prepareAddressTransfer(AddressTransfer $billingAddress)
    {
        $address = new ArvatoRssCustomerAddressTransfer();
        $address->setCountry($this->iso3166Converter->iso2ToNumeric($billingAddress->getIso2Code()));
        $address->setCity($billingAddress->getCity());
        $address->setStreet($billingAddress->getAddress1());
        $address->setStreetNumber($billingAddress->getAddress2());
        $address->setZipCode($billingAddress->getZipCode());

        return $address;
    }
}
