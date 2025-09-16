<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\helpers\CurrencyHelper;

/**
 * Commission class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class Commission
{

    public static function calculateCashback(array $order)
    {
        $cashback = self::findCashback($order['module_id'], $order['advertiser_id']);

        if ($cashback['percent_type'] == 'commission_amount')
        {
            $amount = (float) $order['commission_amount'] * (float) $cashback['percentage_value'] / 100;
            $currency = $order['currency_code'];
        }
        elseif ($cashback['percent_type'] == 'sale_amount')
        {
            $amount = (float) $order['sale_amount'] * (float) $cashback['percentage_value'] / 100;
            $currency = $order['currency_code'];
        }
        elseif ($cashback['percent_type'] == 'flat_amount')
        {
            $amount = (float) $cashback['percentage_value'];
            $currency = $cashback['currency'];
        }
        else
            $amount = $currency = null;

        return array($amount, $currency);
    }

    public static function findCashback($module_id, $advertiser_id)
    {
        $config = ModuleManager::configFactory($module_id);
        $cashback_config = $config->option('cashback');
        $key = array_search((int) $advertiser_id, array_column($cashback_config, 'advertiser_id'));

        if ($key !== false)
            $cashback = $cashback_config[$key];
        else
        {
            $cashback = $config->option('default_cashback');
            $cashback = $cashback[0];
        }
        return $cashback;
    }

    public static function displayAdvertiserComission($advertiser, $module_id = null)
    {
        if (!is_array($advertiser))
            $advertiser = AdvertiserManager::getInstance()->findAdvertiserById($advertiser, $module_id);
        if (!$advertiser)
            return;

        if ($advertiser['commission_type'] == Advertiser::COMMISSION_TYPE_PERCENTAGE)
            $currency = 'PCT';
        else
            $currency = $advertiser['currency_code'];

        if ($advertiser['commission_max'] > $advertiser['commission_min'])
            return CurrencyHelper::getInstance()->currencyFormat($advertiser['commission_min'], $currency) . '-' . CurrencyHelper::getInstance()->currencyFormat($advertiser['commission_max'], $currency);
        else
            return CurrencyHelper::getInstance()->currencyFormat($advertiser['commission_min'], $currency);
    }

    public static function displayAdvertiserCashback($advertiser, $module_id = null)
    {
        if (!is_array($advertiser))
            $advertiser = AdvertiserManager::getInstance()->findAdvertiserById($advertiser, $module_id);

        if (!$advertiser)
            return '';

        if (!$cashback = Commission::findCashback($advertiser['module_id'], $advertiser['id']))
            return;

        if ($cashback['percent_type'] == 'flat_amount')
            return CurrencyHelper::getInstance()->currencyFormat($cashback['percentage_value'], $cashback['currency']);


        if ($cashback['percent_type'] == 'sale_amount')
        {
            $min = 100;
            $max = 100;
        }
        else
        {
            $min = $advertiser['commission_min'];
            $max = $advertiser['commission_max'];
        }

        $cashback_min = round((float) $min * (float) $cashback['percentage_value'] / 100, 2);
        $cashback_max = round((float) $max * (float) $cashback['percentage_value'] / 100, 2);

        if (!$cashback_min && !$cashback_max)
            return '-';

        if ($advertiser['commission_type'] == 'flat')
            $currency = $advertiser['currency_code'];
        else
            $currency = 'PCT';

        $res = CurrencyHelper::getInstance()->currencyFormat($cashback_min, $currency);
        if ($cashback_max > $cashback_min)
            $res .= ' - ' . CurrencyHelper::getInstance()->currencyFormat($cashback_max, $currency);
        return $res;
    }
}
