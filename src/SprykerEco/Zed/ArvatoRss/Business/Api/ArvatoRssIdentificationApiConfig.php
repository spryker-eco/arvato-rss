<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api;

interface ArvatoRssIdentificationApiConfig
{
    public const ARVATORSS_API_IDENTIFICATION_NAMESPACE = 'urn:risk-solution-services-types:v2.1';
    public const ARVATORSS_API_IDENTIFICATION_HEADER_NAME = 'Identification';
    public const ARVATORSS_API_CLIENTID = 'ClientID';
    public const ARVATORSS_API_AUTHORISATION = 'Authorisation';
    public const ARVATORSS_API_COMMUNICATION_TOKEN = 'CommunicationToken';
}
