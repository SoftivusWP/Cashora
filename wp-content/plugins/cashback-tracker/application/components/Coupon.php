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
class Coupon
{

    public $network_id;
    public $type;
    public $code;
    public $title;
    public $link;
    public $image;
    public $description;
    public $discount;
    public $start_date;
    public $end_date;
    public $extra = array();
}
