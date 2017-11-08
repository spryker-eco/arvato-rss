<?php
/**
 * Created by PhpStorm.
 * User: sikachev
 * Date: 11/8/17
 * Time: 4:20 PM
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api\Adapter;


interface AdapterFactoryInterface
{
    public function createRequestHeaderConverter();

    public function createRiskCheckRequestConverter();

    public function createRiskCheckResponeConverter();

    public function createStoreOrderRequestConverter();

    public function createStoreOrderResponseConverter();
}