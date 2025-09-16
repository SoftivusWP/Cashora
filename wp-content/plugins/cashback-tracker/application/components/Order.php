<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

/**
 * Config class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class Order
{

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_DECLINED = 2;

    public $user_id;
    public $order_id;
    public $merchant_order_id;
    public $module_id;
    public $subid;
    public $create_date;
    public $order_status;
    public $completion_date;
    public $advertiser_id;
    public $advertiser_domain;
    public $currency_code;
    public $sale_amount;
    public $commission_amount;
    public $click_date;
    public $action_date;
    public $user_referer;
    public $api_response;
    public $is_correction;
}
