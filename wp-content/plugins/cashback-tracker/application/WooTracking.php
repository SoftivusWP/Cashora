<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\admin\GeneralConfig;
use CashbackTracker\application\components\DeeplinkGenerator;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\AdvertiserManager;

/**
 * WooTracking class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class WooTracking
{
    public static function init()
    {
        if (!GeneralConfig::getInstance()->option('woo_tracking'))
            return;

        \add_filter('woocommerce_product_add_to_cart_url', array(__CLASS__, 'generateTrackingLink'), 100, 2);

        if (GeneralConfig::getInstance()->option('woo_cashback_notice'))
            \add_action('woocommerce_single_product_summary', array(__CLASS__, 'showCashbackNotice'), 20);
    }

    public static function generateTrackingLink($permalink, $product)
    {
        if ($product->get_type() != 'external')
            return $permalink;

        // add tracking to affiliate link
        $tl = DeeplinkGenerator::maybeAddTracking($permalink);
        if ($tl != $permalink)
            return $tl;

        // add tracking to direct link
        if (!$domain = TextHelper::getHostName($permalink))
            return $permalink;

        // admitad as advertiser
        if ($domain == 'admitad.com')
            return $permalink;

        if (!$advertiser = AdvertiserManager::getInstance()->findAdvertiserByDomain($domain))
            return $permalink;

        if ($deeplink = DeeplinkGenerator::generateTrackingLink($advertiser['module_id'], $advertiser['id'], $permalink))
            return $deeplink;

        return $permalink;
    }

    public static function showCashbackNotice()
    {
        global $post;

        $product = \wc_get_product($post->ID);
        if ($product->get_type() != 'external')
            return;

        if (!$cashback_str = DeeplinkGenerator::getCashbackStrByUrl($product->add_to_cart_url()))
            return;

        echo '<span class="cbtrkr_cashback_notice_woo">';
        echo sprintf(__('Plus %s Cash Back', 'cashback-tracker'), $cashback_str);
        echo '</span>';
    }
}
