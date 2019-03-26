<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\ArvatoRss\Business\Api;

interface ArvatoRssRequestApiConfig
{
    public const ARVATORSS_API_COUNTRY = 'Country';
    public const ARVATORSS_API_CITY = 'City';
    public const ARVATORSS_API_STREET = 'Street';
    public const ARVATORSS_API_STREET_NUMBER = 'StreetNumber';
    public const ARVATORSS_API_ZIPCODE = 'ZipCode';
    public const ARVATORSS_API_BILLINGCUSTOMER = 'BillingCustomer';
    public const ARVATORSS_API_DELIVERYCUSTOMER = 'DeliveryCustomer';
    public const ARVATORSS_API_FIRSTNAME = 'FirstName';
    public const ARVATORSS_API_LASTNAME = 'LastName';
    public const ARVATORSS_API_ADDRESS = 'Address';
    public const ARVATORSS_API_ORDER = 'Order';
    public const ARVATORSS_API_REGISTEREDORDER = 'RegisteredOrder';
    public const ARVATORSS_API_ORDER_NUMBER = 'OrderNumber';
    public const ARVATORSS_API_DEBITOR_NUMBER = 'DebitorNumber';
    public const ARVATORSS_API_PAYMENT_TYPE = 'PaymentType';
    public const ARVATORSS_API_CURRENCY = 'Currency';
    public const ARVATORSS_API_GROSSTOTALBILL = 'GrossTotalBill';
    public const ARVATORSS_API_TOTALORDERVALUE = 'TotalOrderValue';
    public const ARVATORSS_API_ITEM = 'Item';
    public const ARVATORSS_API_PRODUCTNUMBER = 'ProductNumber';
    public const ARVATORSS_API_PRODUCTGROUPID = 'ProductGroupId';
    public const ARVATORSS_API_UNITPRICE = 'UnitPrice';
    public const ARVATORSS_API_UNITCOUNT = 'UnitCount';
    public const ARVATORSS_API_STREET_NUMBER_ADDITIONAL = 'StreetNumberAdditional';
}
