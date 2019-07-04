<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Writer;

interface ArvatoRssWriterInterface
{
    /**
     * @param string $communicationToken
     * @param string $orderReference
     *
     * @return void
     */
    public function updateLogWithOrderReference(string $communicationToken, string $orderReference): void;
}
