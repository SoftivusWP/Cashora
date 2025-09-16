<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

/**
 * Advertiser class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class Advertiser
{

    const COMMISSION_TYPE_PERCENTAGE = 'percentage';
    const COMMISSION_TYPE_FLAT = 'flat';

    public $id;
    public $name;
    public $logo_url;
    public $site_url;
    public $domain;
    public $validation_days;
    public $currency_code;
    public $deeplink;
    public $average_payment_time;
    public $commission_min;
    public $commission_max;
    public $commission_type;
    public $_extra = array();
}
