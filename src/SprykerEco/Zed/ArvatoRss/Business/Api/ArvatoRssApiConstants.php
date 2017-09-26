<?php

namespace SprykerEco\Zed\ArvatoRss\Business\Api;

interface ArvatoRssApiConstants
{

    // Request constants
    const ARVATORSS_API_COUNTRY = 'Country';
    const ARVATORSS_API_CITY = 'City';
    const ARVATORSS_API_STREET = 'Street';
    const ARVATORSS_API_STREET_NUMBER = 'StreetNumber';
    const ARVATORSS_API_ZIPCODE = 'ZipCode';
    const ARVATORSS_API_BILLINGCUSTOMER = 'BillingCustomer';
    const ARVATORSS_API_FIRSTNAME = 'FirstName';
    const ARVATORSS_API_LASTNAME = 'LastName';
    const ARVATORSS_API_ADDRESS = 'Address';
    const ARVATORSS_API_ORDER = 'Order';
    const ARVATORSS_API_REGISTEREDORDER = 'RegisteredOrder';
    const ARVATORSS_API_CURRENCY = 'Currency';
    const ARVATORSS_API_GROSSTOTALBILL = 'GrossTotalBill';
    const ARVATORSS_API_TOTALORDERVALUE = 'TotalOrderValue';
    const ARVATORSS_API_ITEM = 'Item';
    const ARVATORSS_API_PRODUCTNUMBER = 'ProductNumber';
    const ARVATORSS_API_PRODUCTGROUPID = 'ProductGroupId';
    const ARVATORSS_API_UNITPRICE = 'UnitPrice';
    const ARVATORSS_API_UNITCOUNT = 'UnitCount';

    // Request: identification part
    const ARVATORSS_API_IDENTIFICATION_NAMESPACE = 'urn:risk-solution-services-types:v2.1';
    const ARVATORSS_API_IDENTIFICATION_HEADER_NAME = 'Identification';
    const ARVATORSS_API_CLIENTID = 'ClientID';
    const ARVATORSS_API_AUTHORISATION = 'Authorisation';

}
