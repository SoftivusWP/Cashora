<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\TemplateManager;
use CashbackTracker\application\components\CouponManager;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\models\CouponModel;

use function CashbackTracker\prnx;

/**
 * ShopsShortcode class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CouponShortcode
{

    const SLUG = 'cashback-coupons';

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;
        return self::$instance;
    }

    private function __construct()
    {
        \add_shortcode(self::getSlug(), array($this, 'coupons'));
        \add_filter('term_description', 'shortcode_unautop');
        \add_filter('term_description', 'do_shortcode');
    }

    static public function getSlug()
    {
        return \apply_filters('cbtrkr_coupons_shortcode', self::SLUG);
    }

    private function prepareAttr($atts)
    {
        $a = \shortcode_atts(array(
            'module_id' => '',
            'module' => '',
            'advertiser' => '',
            'advertiser_id' => '',
            'advertisers' => '',
            'advertiser_ids' => '',
            'id' => '',
            'sort' => '',
            'order' => '',
            'limit' => 50,
            'display_domain' => true,
            'template' => '',
            'type' => '',
        ), $atts);

        $a['module_id'] = \sanitize_text_field($a['module_id']);
        $a['module'] = \sanitize_text_field($a['module']);
        if (!$a['module_id'] && $a['module'])
            $a['module_id'] = $a['module'];
        $a['advertisers'] = \sanitize_text_field($a['advertisers']);
        $a['advertiser_ids'] = \sanitize_text_field($a['advertiser_ids']);
        $a['advertiser'] = \sanitize_text_field($a['advertiser']);
        $a['advertiser_id'] = \sanitize_text_field($a['advertiser_id']);
        $a['id'] = (int) $a['id'];
        if (!$a['advertiser_id'] && $a['advertiser'])
            $a['advertiser_id'] = $a['advertiser'];
        if (!$a['advertiser_id'] && $a['id'])
            $a['advertiser_id'] = $a['id'];
        if (!$a['advertiser_ids'] && $a['advertisers'])
            $a['advertiser_ids'] = $a['advertisers'];
        if (!$a['advertiser_ids'] && $a['advertiser_id'])
            $a['advertiser_ids'] = $a['advertiser_id'];

        if (!$a['limit'] = absint($a['limit']))
            $a['limit'] = 50;
        if ($a['limit'] > 500)
            $a['limit'] = 500;

        $a['display_domain'] = filter_var($a['display_domain'], FILTER_VALIDATE_BOOLEAN);
        $a['template'] = TextHelper::clearId($a['template']);

        if (!$a['template'] || !TemplateManager::getInstance()->isTemplateExists($a['template']))
            $a['template'] = 'cashback-coupons';

        $a['sort'] = strtolower($a['sort']);
        $a['order'] = strtolower($a['order']);
        if (!in_array($a['sort'], array('start_date', 'end_date', 'title', 'discount')))
            $a['sort'] = '';
        if (!in_array($a['order'], array('asc', 'desc')))
            $a['order'] = 'asc';

        $a['type'] = strtolower($a['type']);
        if (!in_array($a['type'], array('coupon', 'deal')))
            $a['type'] = '';

        return $a;
    }

    public function coupons($atts, $content = '')
    {
        $a = $this->prepareAttr($atts);

        $ids = array();
        if ($a['advertiser_ids'])
        {
            $advertiser_ids = TextHelper::getArrayFromCommaList($a['advertiser_ids']);
            $advertiser_ids = CouponManager::prepareAdvertiserIds($advertiser_ids);

            $ids = array_map(function ($id)
            {
                return "'" . \esc_sql($id) . "'";
            }, $advertiser_ids);
        }

        $active_module_ids = ModuleManager::getInstance()->getModulesIdList(true);
        if (!$active_module_ids)
            return;

        if ($a['module_id'])
            $module_ids = array_intersect($a['module_id'], $active_module_ids);
        else
            $module_ids = $active_module_ids;

        if (!$module_ids)
            return;

        $params = array(
            'select' => '*',
            'limit' => $a['limit'],
        );

        $params['where'] = '';
        if ($ids)
            $params['where'] .= 'advertiser_id IN (' . join(',', $ids) . ')';

        if ($module_ids)
        {
            $module_ids = array_map(function ($id)
            {
                return "'" . \esc_sql($id) . "'";
            }, $module_ids);
            if ($params['where'])
                $params['where'] .= ' AND ';
            $params['where'] .= 'module_id IN (' . join(',', $module_ids) . ')';
        }

        if ($a['sort'])
        {
            $params['order'] = $a['sort'];
            if ($params['order'] == 'discount')
                $params['order'] .= '+0'; // natural sorting
            $params['order'] .= ' ' . $a['order'];
        }

        if ($a['type'] && $params['where'])
            $params['where'] .= ' AND ';
        if ($a['type'] == 'coupon')
            $params['where'] .= 'type=' . CouponManager::TYPE_COUPON;
        elseif ($a['type'] == 'deal')
            $params['where'] .= 'type=' . CouponManager::TYPE_DEAL;

        if (!$coupons = CouponModel::model()->findAll($params))
            return;

        $coupons = CouponManager::prepareCoupons($coupons);
        $data = array(
            'a' => $a,
            'coupons' => $coupons,
        );

        return TemplateManager::getInstance()->render($a['template'], $data);
    }
}
