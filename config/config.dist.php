<?php

use SprykerEco\Shared\ArvatoRss\ArvatoRssConstants;

$config[ArvatoRssConstants::ARVATORSS_URL] = '';
$config[ArvatoRssConstants::ARVATORSS_CLIENTID] = '';
$config[ArvatoRssConstants::ARVATORSS_AUTHORISATION] = '';
$config[ArvatoRssConstants::ARVATORSS_PAYMENT_TYPE_MAPPING] = [
    'invoice' => \SprykerEco\Shared\ArvatoRss\ArvatoRssApiConfig::INVOICE,
];
