<?php

namespace CashbackTracker\application\bridges\mycred;

defined('\ABSPATH') || exit;

use CashbackTracker\application\bridges\AbstractBridge;
use CashbackTracker\application\admin\GeneralConfig;
use CashbackTracker\application\Plugin;
use CashbackTracker\application\models\OrderModel;
use CashbackTracker\application\components\Commission;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\helpers\CurrencyHelper;
use CashbackTracker\application\components\Order;

/**
 * MycredBridge class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class MycredBridge extends AbstractBridge
{

    const MYCRED_REFERENCE = 'cashback';

    public function isEnabled()
    {
        if (GeneralConfig::getInstance()->option('mycred_integration') == 'enabled')
            return true;
        else
            return false;
    }

    public function init()
    {
        if ($this->isEnabled() && !self::isMyCredInstalled())
            \add_action('admin_notices', array($this, 'addAdminNotice'));

        if (!$this->isEnabled() || !self::isMyCredInstalled())
            return;

        \add_filter('mycred_give_run', '\__return_false');

        \add_action('cbtrkr_order_create', array($this, 'orderCreate'));
        \add_action('cbtrkr_order_approve', array($this, 'orderApproveDecline'));
        \add_action('cbtrkr_order_decline', array($this, 'orderApproveDecline'));
    }

    public static function isMyCredInstalled()
    {
        if (function_exists('mycred'))
            return true;
        else
            return false;
    }

    public function addAdminNotice()
    {
        $screen = \get_current_screen();
        if ($screen->parent_base != Plugin::getSlug())
            return;

        echo '<div class="notice notice-warning is-dismissible"><p>';
        echo sprintf(__('You have activated myCRED integration, but myCRED plugin is not installed. Please install and activate <a target="_blank" href="%s">myCRED</a> plugin.', 'cashback-tracker'), 'https://wordpress.org/plugins/mycred/');
        echo '</p></div>';
    }

    protected function handleOrder(array $order)
    {
        list($amount, $currency) = Commission::calculateCashback($order);
        $amount = round($amount, 2);
        $log = 'myCRED integration:';
        $log .= ' ' . sprintf(__('Order ID# %d (%d).', 'cashback-tracker'), $order['order_id'], $order['merchant_order_id']);
        if ($amount === null)
        {
            $log .= ' ' . __('Unable to calculate cashback amount.', 'cashback-tracker');
            Plugin::logger()->error($log);
            return false;
        }
        if (!$currency)
        {
            $log = __('Unable to determine cashback currency.', 'cashback-tracker');
            Plugin::logger()->error($log);
            return false;
        }

        $type_id = $this->addPointType($order['order_status'], $currency);

        // Prevent duplicate transactions
        $mycred = \mycred();

        if ($mycred->has_entry(self::MYCRED_REFERENCE, $order['id'], $order['user_id'], $order, $type_id))
        {
            $log = 'myCRED integration:';
            $log .= ' ' . __('Cashback transaction already exists.', 'cashback-tracker');
            $log .= OrderManager::getLogInfo($order);
            Plugin::logger()->warning($log);
            return false;
        }

        $log = 'myCRED integration:';
        $log .= ' ' . __('Cashback points added.', 'cashback-tracker');
        $log .= OrderManager::getLogInfo($order);
        Plugin::logger()->debug($log);
        \mycred_add(self::MYCRED_REFERENCE, $order['user_id'], $amount, sprintf(__('Cashback for Order ID# %s, %s.', 'cashback-tracker'), $order['order_id'], $order['advertiser_domain']), $order['id'], $order, $type_id);

        return $type_id;
    }

    public function orderCreate(array $order)
    {
        $this->handleOrder($order);
    }

    public function orderApproveDecline(array $order)
    {
        if (!$type_id = $this->handleOrder($order))
            return;

        // subtract pending balanse
        global $wpdb, $mycred_log_table;
        //\mycred_delete_user_meta($order['user_id'], $type_id, '_history');
        if ($rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$mycred_log_table} WHERE ref_id = %d AND user_id = %d AND ctype != %s", $order['id'], $order['user_id'], $type_id), \ARRAY_A))
        {
            foreach ($rows as $row)
            {
                $old_status = OrderModel::getStatus(self::getStatusIdByMycredType($row['ctype']));
                $log = sprintf(__('The order status has been changed from %s to %s.', 'cashback-tracker'), $old_status, OrderModel::getStatus($order['order_status']));
                $log .= ' ' . sprintf(__('Order ID# %s, %s.', 'cashback-tracker'), $order['merchant_order_id'], $order['advertiser_domain']);
                \mycred_subtract(self::MYCRED_REFERENCE, $row['user_id'], $row['creds'], $log, $row['ref_id'], $order, $row['ctype']);
            }
        }
    }

    public function addPointType($status, $currency = 'USD')
    {
        $point_type = $this->getPointSlug($status, $currency);

        // exists?
        if (\mycred_point_type_exists($point_type))
            return $point_type;

        if (!\is_mycred_ready())
            MycredHelper::intallMycred();
        else
            MycredHelper::maybeUpdateCoreToDecimal(CurrencyHelper::getInstance()->getValue($currency, 'num_decimals', 2));

        // add point type
        MycredHelper::addPointType($point_type, $this->getPointName($status, $currency));

        // add point options
        $status_name = OrderModel::getStatus($status);
        $name = __('Cashback', 'cashback-tracker') . ' ' . $status_name;
        MycredHelper::addPointOptions($point_type, $currency, $name);

        return $point_type;
    }

    public function getPointSlug($status_id, $currency = 'USD')
    {
        $status = OrderModel::getStatusLatin($status_id);
        return Plugin::short_slug . '_' . \sanitize_key($status) . '_' . \sanitize_key($currency);
    }

    public function getPointName($status_id, $currency = 'USD')
    {
        $status = OrderModel::getStatus($status_id);
        $name = __('Cashback', 'cashback-tracker') . ' ' . $status . ' ' . $currency;
        return \apply_filters('cbtrkr_point_name', $name, $status_id, $currency);
    }

    public static function getStatusIdByMycredType($type)
    {
        if (strstr($type, '_pending_'))
            return Order::STATUS_PENDING;
        elseif (strstr($type, '_approved_'))
            return Order::STATUS_APPROVED;
        elseif (strstr($type, '_declined_'))
            return Order::STATUS_DECLINED;
        else
            return false;
    }
}
