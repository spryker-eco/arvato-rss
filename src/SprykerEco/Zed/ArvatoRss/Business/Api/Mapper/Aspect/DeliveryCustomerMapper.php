<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Mapper\Aspect;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\ArvatoRssDeliveryCustomerTransfer;
use Generated\Shared\Transfer\ArvatoRssCustomerAddressTransfer;
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
     * @param DeliveryCustomerMapperTransfer $deliveryCustomerMapperTransfer
     *
     * @return ArvatoRssDeliveryCustomerTransfer
     */
    public function map(DeliveryCustomerMapperTransfer $deliveryCustomerMapperTransfer)
    {
        $deliveryCustomerTransfer = new ArvatoRssDeliveryCustomerTransfer();
        $deliveryAddress = $deliveryCustomerMapperTransfer->getDeliveryAddress();
        $address = $this->prepareAddressTransfer($deliveryAddress);
        $deliveryCustomerTransfer->setAddress($address);
        $deliveryCustomerTransfer->setFirstName($deliveryAddress->getFirstName());
        $deliveryCustomerTransfer->setLastName($deliveryAddress->getLastName());
        $deliveryCustomerTransfer->setSalutation(strtoupper($deliveryAddress->getSalutation()));
        $deliveryCustomerTransfer->setEmail($deliveryCustomerMapperTransfer->getEmail());
        $deliveryCustomerTransfer->setTelephoneNumber($deliveryAddress->getPhone());

        return $deliveryCustomerTransfer;
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
