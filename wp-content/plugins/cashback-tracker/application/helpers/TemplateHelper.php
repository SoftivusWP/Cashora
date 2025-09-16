<?php

namespace CashbackTracker\application\helpers;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\AdvertiserViewer;
use CashbackTracker\application\admin\GeneralConfig;
use CashbackTracker\application\admin\ShopMetabox;
use CashbackTracker\application\admin\CouponConfig;

/**
 * TemplateHelper class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class TemplateHelper
{

    public static function formatDateHumanReadable($timestamp, $ago = 3600)
    {
        if (time() - $timestamp <= $ago)
            return sprintf(__('%s ago', '%s = human-readable time difference', 'cashback-tracker'), \human_time_diff($timestamp, time()));
        else
            return self::dateFormatFromGmt($timestamp, true);
    }

    public static function dateFormatFromGmt($timestamp, $time = true)
    {
        $format = \get_option('date_format');
        if ($time)
            $format .= ' ' . \get_option('time_format');
        $timestamp = strtotime(\get_date_from_gmt(date('Y-m-d H:i:s', (int) $timestamp)));
        return \date_i18n($format, $timestamp);
    }

    public static function sortPagesByName(array $pages)
    {
        usort($pages, array(__CLASS__, 'sortPages'));
        return $pages;
    }

    private static function sortPages(\WP_Post $a, \WP_Post $b)
    {
        $viewer = AdvertiserViewer::getInstance($a->ID);
        if ($name = $viewer->getName())
            $name1 = $name;
        else
            $name1 = $a->post_title;
        $viewer = AdvertiserViewer::getInstance($b->ID);
        if ($name = $viewer->getName())
            $name2 = $name;
        else
            $name2 = $b->post_title;
        return strcasecmp($name1, $name2);
    }

    public static function getGoShopLink($tracking_link)
    {
        if (\is_user_logged_in())
            return $tracking_link;

        if ($registration_url = GeneralConfig::getInstance()->option('registration_url'))
            return \add_query_arg('redirect_to', \get_permalink(), $registration_url);

        return \site_url('/wp-login.php?action=register&redirect_to=' . \get_permalink());
    }

    public static function getGotoshopButtonClass($add_space = true)
    {
        $class = GeneralConfig::getInstance()->option('gotoshop_button_class');

        if (!$class && self::isRehubTheme() && !is_user_logged_in() && GeneralConfig::getInstance()->option('cashback_section') != 'disabled')
            $class = 'act-rehub-login-popup';

        if ($class && $add_space)
            $class = ' ' . $class;

        return $class;
    }

    public static function isRehubTheme()
    {
        return (in_array(basename(\get_template_directory()), array('rehub', 'rehub-theme'))) ? true : false;
    }

    public static function getAdvertiserViewer($page_id)
    {
        return \CashbackTracker\application\components\AdvertiserViewer::getInstance($page_id);
    }

    public static function getAreaSidebar($page_id)
    {
        return \get_post_meta($page_id, ShopMetabox::PREFIX . 'area_sidebar', true);
    }

    public static function btnTextCoupon($print = true)
    {
        $text = CouponConfig::getInstance()->option('button_text_coupon', '');
        if (!$text)
            $text = __('SHOW CODE', 'cashback-tracker');

        if ($print)
            echo esc_html($text);
        else
            return $text;
    }

    public static function btnTextDeal($print = true)
    {
        $text = CouponConfig::getInstance()->option('button_text_deal', '');
        if (!$text)
            $text = __('GET DEAL', 'cashback-tracker');

        if ($print)
            echo esc_html($text);
        else
            return $text;
    }

    public static function truncate($string, $length = 80, $etc = '...', $charset = 'UTF-8', $break_words = false, $middle = false)
    {
        if ($length == 0)
            return '';

        if (mb_strlen($string, 'UTF-8') > $length)
        {
            $length -= min($length, mb_strlen($etc, 'UTF-8'));
            if (!$break_words && !$middle)
            {
                $string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length + 1, $charset));
            }
            if (!$middle)
            {
                return mb_substr($string, 0, $length, $charset) . $etc;
            }
            else
            {
                return mb_substr($string, 0, $length / 2, $charset) . $etc . mb_substr($string, -$length / 2, $charset);
            }
        }
        else
        {
            return $string;
        }
    }

    public static function couponConfig($option)
    {
        return CouponConfig::getInstance()->option($option);
    }
}
