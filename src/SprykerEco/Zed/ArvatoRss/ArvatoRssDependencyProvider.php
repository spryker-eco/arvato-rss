<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyBridge;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToSalesBridge;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToStoreBridge;

class ArvatoRssDependencyProvider extends AbstractBundleDependencyProvider
{
    public const FACADE_MONEY = 'FACADE_MONEY';
    public const FACADE_STORE = 'FACADE_STORE';
    public const FACADE_SALES = 'FACADE_SALES';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[static::FACADE_MONEY] = function (Container $container) {
            return new ArvatoRssToMoneyBridge($container->getLocator()->money()->facade());
        };

        $container[static::FACADE_STORE] = function (Container $container) {
            return new ArvatoRssToStoreBridge($container->getLocator()->store()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container[static::FACADE_SALES] = function (Container $container) {
            return new ArvatoRssToSalesBridge($container->getLocator()->sales()->facade());
        };

        return $container;
    }
}
