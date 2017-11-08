<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;


interface AdapterFactoryInterface
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RequestHeaderConverter
     */
    public function createRequestHeaderConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface
     */
    public function createRiskCheckRequestConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface
     */
    public function createRiskCheckResponeConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\RiskCheckRequestConverterInterface
     */
    public function createStoreOrderRequestConverter();

    /**
     * @return \SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderResponseConverterInterface
     */
    public function createStoreOrderResponseConverter();
}