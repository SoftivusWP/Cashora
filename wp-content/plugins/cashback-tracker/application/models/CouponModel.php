<?php

namespace CashbackTracker\application\models;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;

/**
 * CouponModel class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CouponModel extends Model
{

    public function tableName()
    {
        return $this->getDb()->prefix . Plugin::getShortSlug() . '_coupon';
    }

    public function getDump()
    {

        return "CREATE TABLE " . $this->tableName() . " (
                    id bigint(20) unsigned NOT NULL auto_increment,
                    module_id varchar(255) NOT NULL,
                    advertiser_id bigint(20) unsigned NOT NULL,
                    type tinyint(1) DEFAULT 0,
                    start_date datetime default '0000-00-00 00:00:00',
                    end_date datetime default '0000-00-00 00:00:00',
                    code varchar(255) DEFAULT NULL,
                    title varchar(255) NOT NULL,
                    discount varchar(255) DEFAULT NULL,
                    link text,
                    image text,
                    description text,
                    extra text,
                    PRIMARY KEY  (id),
                    KEY advertiser_id_module_id (advertiser_id,module_id(12)),
                    KEY module_id (module_id(12)),
                    KEY start_date (start_date),
                    KEY end_date (end_date),
                    KEY type (type)
                    ) $this->charset_collate;";
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function save(array $item)
    {
        if (!isset($item['id']))
            $item['id'] = null;

        if (isset($item['extra']) && is_array($item['extra']))
            $item['extra'] = serialize($item['extra']);

        return parent::save($item);
    }
}
