<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerEco\Zed\ArvatoRss\ArvatoRssDependencyProvider;

/**
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\ArvatoRss\ArvatoRssConfig getConfig()
 * @method \SprykerEco\Zed\ArvatoRss\Persistence\ArvatoRssRepositoryInterface getRepository()
 * @method \SprykerEco\Zed\ArvatoRss\Business\ArvatoRssFacadeInterface getFacade()
 */
class ArvatoRssCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToSalesInterface
     */
    public function getSalesFacade()
    {
        return $this->getProvidedDependency(ArvatoRssDependencyProvider::FACADE_SALES);
    }
}
