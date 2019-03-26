<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ArvatoRssBillingCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\BillingCustomerMapperTransfer;
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
        $addressTransfer = $billingCustomerMapperTransfer->getBillingAddress();
        $customerAddressTransfer = $this->prepareCustomerAddressTransfer($addressTransfer);
        $billingCustomerTransfer->setAddress($customerAddressTransfer);
        $billingCustomerTransfer->setFirstName($addressTransfer->getFirstName());
        $billingCustomerTransfer->setLastName($addressTransfer->getLastName());
        $billingCustomerTransfer->setSalutation(strtoupper($addressTransfer->getSalutation()));
        $billingCustomerTransfer->setEmail($billingCustomerMapperTransfer->getEmail());
        $billingCustomerTransfer->setTelephoneNumber($addressTransfer->getPhone());

        return $billingCustomerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AddressTransfer $addressTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer
     */
    protected function prepareCustomerAddressTransfer(AddressTransfer $addressTransfer)
    {
        $customerAddressTransfer = new ArvatoRssCustomerAddressTransfer();
        $customerAddressTransfer->setCountry($this->iso3166Converter->iso2ToNumeric($addressTransfer->getIso2Code()));
        $customerAddressTransfer->setCity($addressTransfer->getCity());
        $customerAddressTransfer->setStreet($addressTransfer->getAddress1());
        $customerAddressTransfer->setStreetNumber($addressTransfer->getAddress2());
        $customerAddressTransfer->setZipCode($addressTransfer->getZipCode());
        $customerAddressTransfer->setStreetNumberAdditional($addressTransfer->getAddress3());

        return $customerAddressTransfer;
    }
}
