<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\Scheduler;
use CashbackTracker\application\components\CouponManager;
use CashbackTracker\application\admin\CouponConfig;

/**
 * CouponScheduler class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CouponScheduler extends Scheduler
{

    const CRON_TAG = 'cbtrkr_coupon_cron';
    const COUPON_TTL = 43200;
    const UPDATE_LIMIT = 50;

    public static function getCronTag()
    {
        return self::CRON_TAG;
    }

    public static function run()
    {
        @set_time_limit(2000);
        self::updateCoupons();
    }

    public static function updateCoupons()
    {
        self::maybeClearScheduleEvent();

        if (CouponConfig::getInstance()->option('import_coupons') != 'enabled')
            return;

        if (!$ttl = (int) \apply_filters('cbtrkr_coupon_ttl', self::COUPON_TTL))
            return;

        global $wpdb;

        $limit = (int) \apply_filters('cbtrkr_coupon_update_limit', self::UPDATE_LIMIT);
        $time = time();

        $sql = "SELECT last_update.post_id
            FROM    {$wpdb->postmeta} last_update
            WHERE
                {$time} - last_update.meta_value > {$ttl}
                AND last_update.meta_key = %s
            ORDER BY    last_update.meta_value ASC
            LIMIT " . $limit;

        $query = $wpdb->prepare($sql, CouponManager::META_LAST_UPDATE);
        $results = $wpdb->get_results($query);

        if (!$results)
            return;

        foreach ($results as $r)
        {
            CouponManager::getInstance()->updateCoupons($r->post_id);
            sleep(rand(1, 2));
        }
    }

    public static function maybeClearScheduleEvent()
    {
        if (CouponConfig::getInstance()->option('import_coupons') == 'disabled')
            self::clearScheduleEvent();
    }

    public static function maybeAddScheduleEvent()
    {
        if (CouponConfig::getInstance()->option('import_coupons') == 'enabled')
            self::addScheduleEvent('hourly', time() + 5);
    }
}
