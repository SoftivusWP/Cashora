<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\components\OrderManager;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\AdvertiserViewer;
use CashbackTracker\application\admin\GeneralConfig;

/**
 * DeeplinkGenerator class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class DeeplinkGenerator
{

    public static function generateSubid($user_id)
    {
        return OrderManager::getSubidPrefix() . '-' . $user_id;
    }

    public static function getDeeplink($module_id, $advertiser_id)
    {
        if (!$advertiser = AdvertiserManager::getInstance()->getAdvertiser($module_id, $advertiser_id))
            return '';

        if (empty($advertiser['deeplink']))
            return '';

        return $advertiser['deeplink'];
    }

    public static function generateTrackingLink($module_id, $advertiser_id, $product_url = '', $user_id = null)
    {
        if (!$deeplink = self::getDeeplink($module_id, $advertiser_id))
            return '';

        if (!$user_id)
            $user_id = self::getUserId();

        if (strstr($deeplink, '{{') && strstr($deeplink, '}}'))
            return self::generatePatternDeeplink($advertiser_id, $module_id, $deeplink, $product_url, $user_id);
        else
            return self::generateParamsDeeplink($advertiser_id, $module_id, $deeplink, $product_url, $user_id);
    }

    public static function generatePatternDeeplink($advertiser_id, $module_id, $deeplink, $product_url, $user_id)
    {
        if ($user_id)
            $sub_id = self::generateSubid($user_id);
        else
            $sub_id = 'ct';

        if (!$product_url)
        {
            $advertiser = AdvertiserManager::getInstance()->findAdvertiserById($advertiser_id, $module_id);
            $product_url = $advertiser['site_url'];
        }

        $deeplink = str_replace('{{url}}', $product_url, $deeplink);
        $deeplink = str_replace('{{sub_id}}', $sub_id, $deeplink);

        return $deeplink;
    }

    public static function generateParamsDeeplink($advertiser_id, $module_id, $deeplink, $product_url, $user_id)
    {
        $module = ModuleManager::factory($module_id);

        if ($user_id)
        {
            $subid_param = $module->getSubidName();
            $deeplink = \add_query_arg($subid_param, self::generateSubid($user_id), $deeplink);
        }

        if ($product_url)
        {
            $goto_param = $module->getGotoName();
            $deeplink = \add_query_arg($goto_param, $product_url, $deeplink);
        }

        return $deeplink;
    }

    /**
     * CE and AE integration
     */
    public static function maybeAddTracking($url, $user_id = null)
    {
        if (!$user_id)
            $user_id = self::getUserId();

        if (!$user_id)
            return $url;

        if ($module = self::getModuleIfTrackableUrl($url))
        {
            $subid_param = $module->getSubidName();
            return \add_query_arg($subid_param, self::generateSubid($user_id), $url);
        }

        return $url;
    }

    public static function getModuleIfTrackableUrl($url)
    {
        $modules = ModuleManager::getInstance()->getModules(true);
        foreach ($modules as $module)
        {
            if ($module->isTrackableUrl($url))
                return $module;
        }

        return null;
    }

    public static function getCashbackStrByUrl($url)
    {
        if (!$module = self::getModuleIfTrackableUrl($url))
            return '';

        if (!$url_parts = parse_url($url))
            return '';

        if (empty($url_parts['query']))
            return '';

        parse_str($url_parts['query'], $vars);

        // awin fix
        if (strstr($url, 'awin1.com') && isset($vars['m']))
        {
            $advertiser = AdvertiserManager::getInstance()->findAdvertiserById((int) $vars['m'], 'Awin');
        }
        else
        {
            $goto_param = $module->getGotoName();
            if (empty($vars[$goto_param]) || !preg_match('/https?:\/\//', $vars[$goto_param]))
                return '';

            $domain = TextHelper::getHostName($vars[$goto_param]);
            $advertiser = AdvertiserManager::getInstance()->findAdvertiserByDomain($domain, $module->getId());
        }

        if (!$advertiser)
            return '';

        $viewer = AdvertiserViewer::getInstanceByAdvertiser($advertiser['module_id'], $advertiser['id']);
        return $viewer->getCashback($advertiser);
    }

    public static function getUserId()
    {
        global $post;

        if (GeneralConfig::getInstance()->option('force_author_id') && $post)
            $user_id = $post->post_author;
        else
            $user_id = \get_current_user_id();

        return $user_id;
    }
}
