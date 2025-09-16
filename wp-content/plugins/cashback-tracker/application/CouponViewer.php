<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\admin\CouponConfig;
use CashbackTracker\application\admin\ShopMetabox;
use CashbackTracker\application\components\CouponManager;
use CashbackTracker\application\components\TemplateManager;

/**
 * CouponViewer class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CouponViewer
{

    public static function init()
    {
        if (CouponConfig::getInstance()->option('import_coupons') != 'enabled')
            return;

        \add_filter('the_content', array(__CLASS__, 'viewData'), 12);
    }

    public static function viewData($content)
    {
        global $post;

        if (empty($post))
            return;

        if ($post->post_type != 'cbtrkr_shop')
            return $content;

        $page_id = $post->ID;

        $module_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'module_id', true);
        $advertiser_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'advertiser_id', true);

        if (!$module_id || !$advertiser_id)
            return $content;

        CouponManager::getInstance()->updateIfNotExist($page_id);

        if (!$coupons = CouponManager::getInstance()->findCouponsByPage($page_id))
            return $content;

        $html = TemplateManager::getInstance()->render('_coupon_list', array('coupons' => $coupons));

        if (CouponConfig::getInstance()->option('embed_at') == 'top')
            return $html . $content;
        else
            return $content . $html;
    }
}
