<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;

class ArvatoRssConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->get(ArvatoRssConstants::ARVATORSS_CLIENTID);
    }

    /**
     * @return string
     */
    public function getAuthorization()
    {
        return $this->get(ArvatoRssConstants::ARVATORSS_AUTHORISATION);
    }

    /**
     * @param string $paymentMethod
     *
     * @return string
     */
    public function getPaymentTypeMapping($paymentMethod)
    {
        $mapping = $this->get(ArvatoRssConstants::ARVATORSS_PAYMENT_TYPE_MAPPING);

        return $mapping[$paymentMethod];
    }
}
