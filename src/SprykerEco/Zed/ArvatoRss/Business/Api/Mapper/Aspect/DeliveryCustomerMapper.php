<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
use Generated\Shared\Transfer\ArvatoRssDeliveryCustomerTransfer;
use Generated\Shared\Transfer\DeliveryCustomerMapperTransfer;
use SprykerEco\Service\ArvatoRss\Iso3166ConverterServiceInterface;

class DeliveryCustomerMapper implements DeliveryCustomerMapperInterface
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
     * @param \Generated\Shared\Transfer\DeliveryCustomerMapperTransfer $deliveryCustomerMapperTransfer
     *
     * @return \Generated\Shared\Transfer\ArvatoRssDeliveryCustomerTransfer
     */
    public function map(DeliveryCustomerMapperTransfer $deliveryCustomerMapperTransfer)
    {
        $deliveryCustomerTransfer = new ArvatoRssDeliveryCustomerTransfer();
        $deliveryAddressTransfer = $deliveryCustomerMapperTransfer->getDeliveryAddress();
        $customerAddressTransfer = $this->prepareCustomerAddressTransfer($deliveryAddressTransfer);
        $deliveryCustomerTransfer->setAddress($customerAddressTransfer);
        $deliveryCustomerTransfer->setFirstName($deliveryAddressTransfer->getFirstName());
        $deliveryCustomerTransfer->setLastName($deliveryAddressTransfer->getLastName());
        $deliveryCustomerTransfer->setSalutation(strtoupper($deliveryAddressTransfer->getSalutation()));
        $deliveryCustomerTransfer->setEmail($deliveryCustomerMapperTransfer->getEmail());
        $deliveryCustomerTransfer->setTelephoneNumber($deliveryAddressTransfer->getPhone());

        return $deliveryCustomerTransfer;
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

        return $customerAddressTransfer;
    }
}
