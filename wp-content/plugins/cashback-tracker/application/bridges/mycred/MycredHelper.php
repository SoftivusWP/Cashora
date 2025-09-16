<?php

namespace CashbackTracker\application\bridges\mycred;

defined('\ABSPATH') || exit;

use CashbackTracker\application\helpers\CurrencyHelper;

/**
 * MycredHelper file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class MycredHelper
{

    public static function intallMycred($add_default_point_type = true)
    {
        // Install database
        if (!function_exists('mycred_install_log'))
            require_once \myCRED_INCLUDES_DIR . 'mycred-functions.php';

        \mycred_install_log($decimals = 2, true);
        \mycred_add_option('mycred_setup_completed', time());

        if ($add_default_point_type)
            self::addDefaultPointType();
    }

    public static function addDefaultPointType()
    {
        $mycred = \mycred();
        $settings = $mycred->defaults();
        $settings['format']['type'] = 'decimal';
        $settings['format']['decimals'] = 2;
        // Save our first point type
        \mycred_update_option('mycred_pref_core', $settings);
    }

    public static function maybeUpdateCoreToDecimal($num_decimals)
    {
        $core = \mycred_get_option('mycred_pref_core');
        if (!$core || $core['format']['decimals'] > 0)
            return;
        if (!$num_decimals)
            $num_decimals = 2;
        self::setDecimalCredFormat($num_decimals);
    }

    public static function setDecimalCredFormat($decimals = 2)
    {
        global $wpdb, $mycred_log_table;
        $decimals = 2;
        $format = 'decimal';
        if ($decimals > 4)
            $cred_format = "decimal(32,$decimals)";
        else
            $cred_format = "decimal(22,$decimals)";

        // Alter table
        $wpdb->query("ALTER TABLE {$mycred_log_table} MODIFY creds {$cred_format} DEFAULT NULL;");

        // Save settings
        $settings = \mycred_get_option('mycred_pref_core');
        $settings['format']['type'] = $format;
        $settings['format']['decimals'] = $decimals;
        \mycred_update_option('mycred_pref_core', $settings);
    }

    public static function addPointType($point_type, $point_name)
    {
        $available_types = \mycred_get_option('mycred_types', array(\MYCRED_DEFAULT_TYPE_KEY => \mycred_label()));
        $available_types[$point_type] = $point_name;
        \mycred_update_option('mycred_types', $available_types);

        global $mycred_types, $mycred_current_account;
        $mycred_types = \apply_filters('mycred_types', $available_types);
        $mycred_current_account->balance[$point_type] = false;
    }

    public static function addPointOptions($point_type, $currency, $name = '')
    {
        $option_id = 'mycred_pref_core';
        $option_id .= '_' . $point_type;

        $mycred = \mycred();
        $settings = $mycred->defaults();
        $settings['cred_id'] = $point_type;
        if (isset($point_type['caching']))
            unset($point_type['caching']);
        $settings['format']['type'] = 'decimal';
        if (!$num_decimals = CurrencyHelper::getInstance()->getValue($currency, 'num_decimals', 2))
            $num_decimals = 2;
        $settings['format']['decimals'] = $num_decimals;
        $decimal_sep = CurrencyHelper::getInstance()->getValue($currency, 'decimal_sep', '.');
        $thousand_sep = CurrencyHelper::getInstance()->getValue($currency, 'thousand_sep', ',');
        $settings['format']['separators']['decimal'] = $decimal_sep;
        $settings['format']['separators']['thousand'] = $thousand_sep;
        if (!$name)
            $name = __('Cashback', 'cashback-tracker');
        $settings['name']['singular'] = $name;
        $settings['name']['plural'] = $name;
        $symbol = CurrencyHelper::getInstance()->getSymbol($currency);
        $currency_pos = CurrencyHelper::getInstance()->getCurrencyPos($currency);
        if (in_array($currency_pos, array('right', 'right_space')))
            $settings['after'] = $symbol;
        else
            $settings['before'] = $symbol;
        \mycred_update_option($option_id, $settings);
    }
}
