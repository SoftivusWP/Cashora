<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\helpers\CurrencyHelper;
use CashbackTracker\application\components\Order;
use CashbackTracker\application\models\OrderModel;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\helpers\TextHelper;

/**
 * OrderTable class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class OrderTable extends MyListTable
{

    const per_page = 20;

    function get_columns()
    {
        return
            array(
                'id' => __('ID', 'cashback-tracker'),
                'create_date' => OrderModel::model()->getAttributeLabel('create_date'),
                'action_date' => OrderModel::model()->getAttributeLabel('action_date'),
                'user_id' => __('User', 'cashback-tracker'),
                'order_id' => __('Order ID (network)', 'cashback-tracker'),
                'merchant_order_id' => __('Order ID (merchant)', 'cashback-tracker'),
                'module_id' => __('Module', 'cashback-tracker'),
                'advertiser_id' => __('Advertiser', 'cashback-tracker'),
                'order_status' => __('Status', 'cashback-tracker'),
                'sale_amount' => __('Sale amount', 'cashback-tracker'),
                'commission_amount' => __('Commission', 'cashback-tracker'),
            );
    }

    function column_user_id($item)
    {
        $res = '#' . $item['user_id'] . ':';
        if (!$user_info = \get_userdata($item['user_id']))
            return __('Not found', 'cashback-tracker');
        $res .= ' ' . '<a href="mailto:' . \esc_attr($user_info->user_email) . '">' . \esc_html($user_info->user_email) . '</a>';
        return $res;
    }

    function column_action_date($item)
    {
        return $this->view_column_date($item, 'action_date');
    }

    function column_module_id($item)
    {
        return '<strong>' . \esc_html($item['module_id']) . '</strong>';
    }

    function column_advertiser_id($item)
    {
        $res = '#' . $item['advertiser_id'] . ':';
        $res .= ' ' . '<ins>' . \esc_html($item['advertiser_domain']) . '</ins>';
        return $res;
    }

    function column_sale_amount($item)
    {
        $res = CurrencyHelper::getInstance()->currencyFormat($item['sale_amount'], $item['currency_code']);
        return '<ins>' . \esc_html($res) . '</ins>';
    }

    function column_commission_amount($item)
    {
        $res = CurrencyHelper::getInstance()->currencyFormat($item['commission_amount'], $item['currency_code']);
        return '<ins>' . \esc_html($res) . '</ins>';
    }

    function column_order_status($item)
    {
        if ($item['order_status'] == Order::STATUS_DECLINED)
            $class = 'declined';
        elseif ($item['order_status'] == Order::STATUS_APPROVED)
            $class = 'approved';
        elseif ($item['order_status'] == Order::STATUS_PENDING)
            $class = 'pending';
        else
            $class = '';

        return '<mark class="' . \esc_attr($class) . '">' . OrderModel::getStatus($item['order_status']) . '</mark>';
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'order_status' => array('order_status', true),
            'user_id' => array('user_id', true),
            'id' => array('id', true),
            'module_id' => array('module_id', true),
            'advertiser_id' => array('advertiser_id', true),
            'create_date' => array('create_date', true),
            'sale_amount' => array('sale_amount', true),
            'commission_amount' => array('commission_amount', true),
            'order_id' => array('order_id', true),
            'merchant_order_id' => array('merchant_order_id', true),
            'action_date' => array('action_date', true),
        );

        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        return array();
    }

    protected function extra_tablenav($which)
    {
        if ($which != 'top')
            return;

        echo '<div class="alignleft actions">';

        $this->print_modules_dropdown();
        \submit_button(__('Filter', 'cashback-tracker'), '', 'filter_action', false, array('id' => 'product-query-submit'));

        echo '</div>';
    }

    private function print_modules_dropdown()
    {
        $modules = ModuleManager::getInstance()->getModulesIdList(true);
        $selected_module_id = !empty($_GET['module_id']) ? TextHelper::clear(\wp_unslash($_GET['module_id'])) : '';

        echo '<select name="module_id" id="dropdown_module_id"><option value="">' . \esc_html__('Filter by module', 'cashback-tracker') . '</option>';
        foreach ($modules as $module_id)
        {
            echo '<option ' . \selected($module_id, $selected_module_id, false) . ' value="' . \esc_attr($module_id) . '">' . \esc_html($module_id) . '</option>';
        }
        echo '</select>';
    }

    protected function getWhereFilters()
    {
        global $wpdb;

        $where = '';

        // search
        if (!empty($_REQUEST['s']))
        {
            $s = \sanitize_text_field(trim($_REQUEST['s']));
            if ($where)
                $where .= ' AND ';
            $where .= sprintf('(id=%d OR order_id=%d OR merchant_order_id=%s)', $s, $s, $s);
        }

        // filters
        if (isset($_GET['order_status']) && $_GET['order_status'] !== '' && $_GET['order_status'] !== 'all')
        {
            $order_status = (int) $_GET['order_status'];

            if (array_key_exists($order_status, OrderModel::getStatuses()))
            {
                if ($where)
                    $where .= ' AND ';

                $where .= $wpdb->prepare('order_status = %d', $order_status);
            }
        }

        if (isset($_GET['module_id']) && $_GET['module_id'] !== '')
        {
            $module_id = TextHelper::clear(\wp_unslash($_GET['module_id']));
            if (ModuleManager::getInstance()->moduleExists($module_id))
            {
                if ($where)
                    $where .= ' AND ';
                $where .= $wpdb->prepare('module_id = %s', $module_id);
            }
        }

        return $where;
    }

    protected function get_views()
    {
        $status_links = array();
        $class = (!isset($_REQUEST['order_status']) || $_REQUEST['order_status'] === '' || $_REQUEST['order_status'] === 'all') ? ' class="current"' : '';
        $admin_url = \get_admin_url(\get_current_blog_id(), 'admin.php?page=' . Plugin::slug() . '-orders');

        $statuses = OrderModel::getStatuses();
        $total = OrderModel::model()->count();
        $status_links['all'] = '<a href="' . $admin_url . '&order_status=all"' . $class . '>' . __('All', 'cashback-tracker') . sprintf(' <span class="count">(%s)</span></a>', \number_format_i18n($total));
        foreach ($statuses as $status_id => $status_name)
        {
            $total = OrderModel::model()->count('order_status = ' . (int) $status_id);
            $class = (isset($_REQUEST['order_status']) && $_REQUEST['order_status'] !== '' && (int) $_REQUEST['order_status'] == $status_id) ? ' class="current"' : '';
            $status_links[$status_id] = '<a href="' . $admin_url . '&order_status=' . (int) $status_id . '"' . $class . '>' . \esc_html($status_name);
            $status_links[$status_id] .= sprintf(' <span class="count">(%s)</span></a>', \number_format_i18n($total));
        }

        return $status_links;
    }
}
