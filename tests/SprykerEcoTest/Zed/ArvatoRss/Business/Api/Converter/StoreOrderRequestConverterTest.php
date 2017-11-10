<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\ArvatoRss\Business\Api\Converter;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\ArvatoRssStoreOrderRequestBuilder;
use Generated\Shared\Transfer\ArvatoRssStoreOrderRequestTransfer;
use SprykerEco\Zed\ArvatoRss\Business\Api\ArvatoRssRequestApiConstants;
use SprykerEco\Zed\ArvatoRss\Business\Api\Converter\StoreOrderRequestConverter;

class StoreOrderRequestConverterTest extends Test
{
    /**
     * @return void
     */
    public function testConvert()
    {
        $converter = new StoreOrderRequestConverter();
        $requestTransfer = (new ArvatoRssStoreOrderRequestBuilder())
            ->withIdentification()
            ->withOrder()
            ->build();
        $result = $converter->convert($requestTransfer);
        $this->testResult($result, $requestTransfer);
    }

    /**
     * @return void
     */
    protected function testResult(array $result, ArvatoRssStoreOrderRequestTransfer $requestTranfer)
    {
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_REGISTEREDORDER],
            $requestTranfer->getOrder()->getRegisteredOrder()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_CURRENCY],
            $requestTranfer->getOrder()->getCurrency()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_GROSSTOTALBILL],
            $requestTranfer->getOrder()->getGrossTotalBill()
        );
        $this->assertEquals(
            $result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_TOTALORDERVALUE],
            $requestTranfer->getOrder()->getTotalOrderValue()
        );

        foreach ($result[ArvatoRssRequestApiConstants::ARVATORSS_API_ORDER][ArvatoRssRequestApiConstants::ARVATORSS_API_ITEM] as $key => $item) {
            $this->assertArrayHasKey($key, $requestTranfer->getOrder()->getItems());
            $this->assertEquals(
                $item[ArvatoRssRequestApiConstants::ARVATORSS_API_PRODUCTNUMBER],
                $requestTranfer->getOrder()->getItems()[$key]->getProductNumber()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConstants::ARVATORSS_API_PRODUCTGROUPID],
                $requestTranfer->getOrder()->getItems()[$key]->getProductGroupId()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConstants::ARVATORSS_API_UNITPRICE],
                $requestTranfer->getOrder()->getItems()[$key]->getUnitPrice()
            );
            $this->assertEquals(
                $item[ArvatoRssRequestApiConstants::ARVATORSS_API_UNITCOUNT],
                $requestTranfer->getOrder()->getItems()[$key]->getUnitCount()
            );
        }
    }
}
