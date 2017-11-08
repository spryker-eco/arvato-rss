<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\ArvatoRss\Dependency\Facade\ArvatoRssToMoneyBridge;

class ArvatoRssDependencyProvider extends AbstractBundleDependencyProvider
{
    const FACADE_MONEY = "FACADE_MONEY";

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

        return $container;
    }
}
