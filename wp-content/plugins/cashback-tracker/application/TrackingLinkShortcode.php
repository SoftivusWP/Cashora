<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\components\DeeplinkGenerator;

/**
 * TrackingLinkShortcode class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class TrackingLinkShortcode
{

    const SLUG = 'tracking-link';

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;
        return self::$instance;
    }

    private function __construct()
    {
        \add_shortcode(self::getSlug(), array($this, 'trackingLink'));
        \add_filter('term_description', 'shortcode_unautop');
        \add_filter('term_description', 'do_shortcode');
    }

    static public function getSlug()
    {
        return \apply_filters('cbtrkr_tracking_link_shortcode', self::SLUG);
    }

    private function prepareAttr($atts)
    {
        $a = \shortcode_atts(array(
            'module_id' => '',
            'module' => '',
            'advertiser' => '',
            'advertiser_id' => '',
            'anchor' => null,
            'text' => null,
            'product' => '',
            'product_url' => '',
            'class' => '',
            'target' => '',
            'rel' => '',
        ), $atts);

        $a['module_id'] = TextHelper::clear($a['module_id']);
        $a['module'] = TextHelper::clear($a['module']);
        if (!$a['module_id'] && $a['module'])
            $a['module_id'] = $a['module'];

        $a['advertiser'] = \sanitize_text_field($a['advertiser']);
        $a['advertiser_id'] = \sanitize_text_field($a['advertiser_id']);
        if (!$a['advertiser_id'] && $a['advertiser'])
            $a['advertiser_id'] = $a['advertiser'];

        $a['text'] = \sanitize_text_field($a['text']);
        $a['anchor'] = \sanitize_text_field($a['anchor']);
        if (!$a['anchor'] && $a['text'])
            $a['anchor'] = $a['text'];

        $a['product'] = $a['product'];
        $a['product_url'] = $a['product_url'];
        if (!$a['product_url'] && $a['product'])
            $a['product_url'] = $a['product'];

        $a['class'] = \sanitize_text_field($a['class']);
        $a['target'] = \sanitize_text_field($a['target']);
        $a['rel'] = \sanitize_text_field($a['rel']);

        return $a;
    }

    public function trackingLink($atts, $content = '')
    {
        $a = $this->prepareAttr($atts);

        if (!$a['advertiser_id'])
            return;

        // find advertiser. module_id is not required
        if (is_numeric($a['advertiser_id']))
        {
            $advertiser = AdvertiserManager::getInstance()->findAdvertiserById($a['advertiser_id'], $a['module_id']);
        }
        else
        {
            if (!$domain = TextHelper::getHostName($a['advertiser_id']))
                $domain = TextHelper::getDomainWithoutSubdomain($a['advertiser_id']);
            $advertiser = AdvertiserManager::getInstance()->findAdvertiserByDomain($domain, $a['module_id']);
        }

        if (!$advertiser)
            return;

        if (!$a['module_id'])
            $a['module_id'] = $advertiser['module_id'];
        if (!ModuleManager::getInstance()->moduleExists($a['module_id']) || !ModuleManager::getInstance()->isModuleActive($a['module_id']))
            return;

        if ($content)
            $a['anchor'] = $content;

        if (!$deeplink = DeeplinkGenerator::generateTrackingLink($a['module_id'], $advertiser['id'], $a['product_url']))
            return;

        if ($a['anchor'] === '')
            return \esc_url($deeplink);
        else
        {
            $res = '<a href="' . \esc_url($deeplink) . '"';
            if ($a['rel'])
                $res .= ' rel="' . \esc_attr($a['rel']) . '"';
            else
                $res .= ' rel="nofollow"';
            if ($a['target'])
                $res .= ' target="' . \esc_attr($a['target']) . '"';
            if ($a['class'])
                $res .= ' class="' . \esc_attr($a['class']) . '"';

            $res .= '>';
            $res .= \esc_html($a['anchor']);
            $res .= '</a>';

            return $res;
        }
    }
}
