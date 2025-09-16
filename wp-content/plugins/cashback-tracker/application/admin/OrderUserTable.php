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
 * OrderUserTable class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class OrderUserTable extends MyListTable
{

    const per_page = 20;

    function get_columns()
    {
        return
            array(
                'merchant_order_id' => __('Order ID', 'cashback-tracker'),
                'advertiser_id' => __('Merchant', 'cashback-tracker'),
                'create_date' => OrderModel::model()->getAttributeLabel('create_date'),
                'action_date' => OrderModel::model()->getAttributeLabel('action_date'),
                'order_status' => __('Status', 'cashback-tracker'),
                'sale_amount' => __('Sale amount', 'cashback-tracker'),
            );
    }

    function column_action_date($item)
    {
        return $this->view_column_date($item, 'action_date');
    }

    function column_advertiser_id($item)
    {
        $res = '<ins>' . \esc_html($item['advertiser_domain']) . '</ins>';
        return $res;
    }

    function column_sale_amount($item)
    {
        $res = CurrencyHelper::getInstance()->currencyFormat($item['sale_amount'], $item['currency_code']);
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
            'advertiser_id' => array('advertiser_id', true),
            'create_date' => array('create_date', true),
            'sale_amount' => array('sale_amount', true),
            'merchant_order_id' => array('merchant_order_id', true),
            'action_date' => array('action_date', true),
        );

        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        return array();
    }

    protected function getWhereFilters()
    {
        $where = 'user_id=' . (int) \get_current_user_id();
        return $where;
    }
}
