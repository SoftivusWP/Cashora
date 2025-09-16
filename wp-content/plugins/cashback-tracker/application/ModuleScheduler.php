<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\Scheduler;
use CashbackTracker\application\admin\GeneralConfig;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\components\OrderManager;

/**
 * ModuleScheduler class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ModuleScheduler extends Scheduler
{
    const CRON_TAG = 'cbtrkr_module_cron';

    public static function getCronTag()
    {
        return self::CRON_TAG;
    }

    public static function run()
    {
        @set_time_limit(600);
        self::downloadOffers();
    }

    public static function downloadOffers()
    {
        if (!$automatically_check = (int) \apply_filters('cbtrkr_automatically_check', GeneralConfig::getInstance()->option('automatically_check')))
            return;

        $last_download_date_option = 'cbtrkr_last_download_date';
        $last_download_date = \get_option($last_download_date_option, 0);

        if ($last_download_date && time() - $last_download_date < $automatically_check - 60 * 3)
            return;

        \update_option($last_download_date_option, time());

        $active_modules = ModuleManager::getInstance()->getModules(true);
        foreach ($active_modules as $module)
        {
            OrderManager::getInstance()->downloadOrders($module->getId());
        }
    }
}
