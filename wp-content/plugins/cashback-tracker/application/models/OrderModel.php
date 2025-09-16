<?php

namespace CashbackTracker\application\models;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Order;

/**
 * OrderModel class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class OrderModel extends Model
{

    public function tableName()
    {
        return $this->getDb()->prefix . Plugin::getShortSlug() . '_order';
    }

    public function getDump()
    {
        return "CREATE TABLE " . $this->tableName() . " (
                    id bigint(20) unsigned NOT NULL auto_increment,
                    user_id bigint(20) unsigned NOT NULL,
                    order_id bigint(20) unsigned NOT NULL,
                    merchant_order_id varchar(255) DEFAULT NULL,
                    module_id varchar(255) NOT NULL,
                    create_date datetime NOT NULL,
                    order_status tinyint(1) NOT NULL,
                    completion_date datetime default '0000-00-00 00:00:00',
                    advertiser_id bigint(20) unsigned NOT NULL,
                    advertiser_domain varchar(255) NOT NULL,
                    currency_code char(3) DEFAULT NULL,
                    sale_amount float(12,2) DEFAULT NULL,
                    commission_amount float(12,2) DEFAULT NULL,
                    subid varchar(255) DEFAULT NULL,
                    click_date datetime default '0000-00-00 00:00:00',
                    action_date datetime NOT NULL default '0000-00-00 00:00:00',
                    user_referer text,
                    api_response text,
                    PRIMARY KEY  (id),
                    KEY order_id_module_id (order_id,module_id(12)),
                    KEY module_id (module_id(12)),
                    KEY merchant_order_id (merchant_order_id(12)),
                    KEY user_id (user_id),
                    KEY create_date (create_date),
                    KEY action_date (action_date),
                    KEY order_status (order_status)
                    ) $this->charset_collate;";
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => __('User ID', 'cashback-tracker'),
            'order_id' => __('Order ID', 'cashback-tracker'),
            'module_id' => __('Network ID', 'cashback-tracker'),
        );
    }

    static public function getStatuses()
    {
        return array(
            Order::STATUS_PENDING => __('Pending', 'cashback-tracker'),
            Order::STATUS_APPROVED => __('Approved', 'cashback-tracker'),
            Order::STATUS_DECLINED => __('Declined', 'cashback-tracker'),
        );
    }

    static public function getStatus($status_id)
    {
        $statuses = OrderModel::getStatuses();
        if (isset($statuses[$status_id]))
            return $statuses[$status_id];
        else
            return null;
    }

    static public function getStatusesLatin()
    {
        return array(
            Order::STATUS_PENDING => 'Pending',
            Order::STATUS_APPROVED => 'Approved',
            Order::STATUS_DECLINED => 'Declined',
        );
    }

    static public function getStatusLatin($status_id)
    {
        $statuses = OrderModel::getStatusesLatin();
        if (isset($statuses[$status_id]))
            return $statuses[$status_id];
        else
            return null;
    }

    public function save(array $item)
    {
        if (empty($item['create_date']))
            $item['create_date'] = \current_time('mysql', true);

        if (!isset($item['id']))
            $item['id'] = null;

        if (isset($item['order_status']) && ($item['order_status'] == Order::STATUS_APPROVED || $item['order_status'] == Order::STATUS_DECLINED))
            $item['completion_date'] = \current_time('mysql', true);

        if (array_key_exists('is_correction', $item))
            unset($item['is_correction']);

        return parent::save($item);
    }

    public static function fireEventOrderCreate($id)
    {
        $order = OrderModel::model()->findbyPk($id);
        \do_action('cbtrkr_order_create', $order);
    }

    public static function fireEventOrderApprove($id)
    {
        $order = OrderModel::model()->findbyPk($id);
        \do_action('cbtrkr_order_approve', $order);
    }

    public static function fireEventOrderDecline($id)
    {
        $order = OrderModel::model()->findbyPk($id);
        \do_action('cbtrkr_order_decline', $order);
    }

    public static function isComplited($order)
    {
        if ($order['order_status'] == Order::STATUS_PENDING)
            return false;
        else
            return true;
    }
}
