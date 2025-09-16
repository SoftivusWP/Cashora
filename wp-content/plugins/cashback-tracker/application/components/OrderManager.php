<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\helpers\ArrayHelper;
use CashbackTracker\application\models\OrderModel;

/**
 * OrderManager class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class OrderManager
{

    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new self;
        return self::$instance;
    }

    static public function getSubidPrefix()
    {
        return \apply_filters('cbtrkr_subid_prefix', 'cbtrkr');
    }

    static public function isCashbackSubid($subid)
    {
        $parts = explode('-', $subid);
        if (count($parts) == 2 && $parts[0] == self::getSubidPrefix() && is_numeric($parts[1]))
            return true;
        else
            return false;
    }

    static public function parseUserId($subid)
    {
        if (!self::isCashbackSubid($subid))
            return null;

        $parts = explode('-', $subid);
        return (int) $parts[1];
    }

    public function downloadOrders($module_id)
    {
        @set_time_limit(100);

        if (!ModuleManager::getInstance()->moduleExists($module_id) || !ModuleManager::getInstance()->isModuleActive($module_id))
            return false;

        $module = ModuleManager::getInstance()->factory($module_id);
        if (!$module->isCashebackModule())
            return false;

        try
        {
            $orders = $module->getOrders();
        }
        catch (\Exception $e)
        {
            Plugin::logger()->error($module->getId() . ' error: ' . $e->getMessage());
            return false;
        }
        if (!$orders)
            $orders = array();

        $log = sprintf(__('%s orders has been loaded successfully.', 'cashback-tracker'), $module->getId());

        if ($start_date = $module->getDateStart('Y/m/d'))
            $log .= ' ' . sprintf(__('Start date: %s.', 'cashback-tracker'), $start_date);

        $log .= ' ' . sprintf(__('Found cashback orders: %d.', 'cashback-tracker'), count($orders));
        Plugin::logger()->debug($log);

        foreach ($orders as $order)
        {
            $order = $this->presavePrepare($order, $module->getId());
            if (!$order)
            {
                //Plugin::logger()->warning(__('Wrong formatted order.', 'cashback-tracker') . self::getLogInfo($order));
                continue;
            }
            $this->saveOrder($order);
        }
    }

    public function presavePrepare(Order $order, $module_id)
    {
        if (!$user_id = self::parseUserId($order->subid))
            return false;

        $user = \get_userdata($user_id);
        if (!$user)
        {
            $log_order['user_id'] = $user_id;
            Plugin::logger()->info(__('User not found.', 'cashback-tracker') . self::getLogInfo($log_order));
            return false;
        }
        $order->user_id = $user_id;
        $order->module_id = $module_id;
        $order->sale_amount = (float) $order->sale_amount;
        $order->commission_amount = (float) $order->commission_amount;
        if (!is_string($order->api_response))
            $order->api_response = serialize($order->api_response);

        if (is_numeric($order->click_date))
            $order->click_date = date('Y-m-d H:i:s', $order->click_date);
        if (is_numeric($order->action_date))
            $order->action_date = date('Y-m-d H:i:s', $order->action_date);

        return ArrayHelper::object2Array($order);
    }

    public function saveOrder(array $order)
    {
        $where = array('order_id = %d AND module_id = %s', array($order['order_id'], $order['module_id']));
        $existed_order = OrderModel::model()->find(array('where' => $where));
        if (!$existed_order)
        {
            $this->createOrder($order);
            return;
        }
        if (OrderModel::isComplited($existed_order))
            return;
        $update = array();
        if ((float) $order['sale_amount'] != (float) $existed_order['sale_amount'])
            $update['sale_amount'] = $existed_order['sale_amount'];
        if ((float) $order['commission_amount'] != (float) $existed_order['commission_amount'])
            $update['commission_amount'] = $existed_order['commission_amount'];
        if ($update)
        {
            $update['id'] = $existed_order['id'];
            OrderModel::model()->save($update);
            Plugin::logger()->info(__('Sale amount/commission amount has been updated.', 'cashback-tracker') . self::getLogInfo($order));
        }
        if ($order['order_status'] != $existed_order['order_status'])
            $this->setOrderStatus($existed_order['id'], $order['order_status']);
    }

    public function createOrder(array $order)
    {
        $orig_status = $order['order_status'];
        if ($order['order_status'] != Order::STATUS_PENDING)
            $order['order_status'] = Order::STATUS_PENDING;

        $id = OrderModel::model()->save($order);
        $order['id'] = $id;
        OrderModel::fireEventOrderCreate($id);
        Plugin::logger()->info(__('New order has been added.', 'cashback-tracker') . self::getLogInfo($order));
        if ($orig_status != Order::STATUS_PENDING)
            $this->setOrderStatus($id, $orig_status);
    }

    public function setOrderStatus($id, $status)
    {
        $order = array(
            'id' => $id,
            'order_status' => $status,
        );
        OrderModel::model()->save($order);
        Plugin::logger()->info(__('Order status has been updated.', 'cashback-tracker') . self::getLogInfo($id));

        if ($status == Order::STATUS_APPROVED)
            OrderModel::fireEventOrderApprove($id);
        elseif ($status == Order::STATUS_DECLINED)
            OrderModel::fireEventOrderDecline($id);
    }

    public static function getLogInfo($order)
    {
        if (!is_array($order) && is_numeric($order))
            $order = OrderModel::model()->findbyPk($order);
        if (!$order)
            return '';

        $order = (array) $order;
        if (!isset($order['id']))
            $order['id'] = 0;
        $log = '';
        if (isset($order['module_id']))
            $log .= ' ' . sprintf(__('Network: %s.', 'cashback-tracker'), $order['module_id']);
        if (isset($order['advertiser_domain']))
            $log .= ' ' . sprintf(__('Advertiser: %s.', 'cashback-tracker'), $order['advertiser_domain']);
        if (isset($order['order_id']))
            $log .= ' ' . sprintf(__('Order ID# %s (%s).', 'cashback-tracker'), $order['order_id'], $order['merchant_order_id']);
        //if (isset($order['subid']))
        //$log .= ' ' . sprintf(__('Subid: %s.', 'cashback-tracker'), $order['subid']);
        if (isset($order['user_id']))
            $log .= ' ' . sprintf(__('User ID# %d.', 'cashback-tracker'), $order['user_id']);
        if (isset($order['order_status']))
            $log .= ' ' . sprintf(__('Status: %s.', 'cashback-tracker'), OrderModel::getStatus($order['order_status']));
        return $log;
    }
}
