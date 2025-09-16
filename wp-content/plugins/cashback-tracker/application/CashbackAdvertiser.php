<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\components\Commission;
use CashbackTracker\application\components\AdvertiserViewer;

/**
 * CashbackAdvertiser class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CashbackAdvertiser
{

    const SLUG = 'cashback-advertiser';

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;
        return self::$instance;
    }

    private function __construct()
    {
        \add_shortcode(self::getSlug(), array($this, 'shop'));
        \add_filter('term_description', 'shortcode_unautop');
        \add_filter('term_description', 'do_shortcode');
    }

    static public function getSlug()
    {
        return \apply_filters('cbtrkr_advertiser_shortcode', self::SLUG);
    }

    private function prepareAttr($atts)
    {
        $a = \shortcode_atts(array(
            'module_id' => '',
            'module' => '',
            'advertiser' => '',
            'advertiser_id' => '',
            'id' => '',
            'display' => '',
        ), $atts);

        $a['display'] = TextHelper::clear($a['display']);

        $a['module_id'] = TextHelper::clear($a['module_id']);
        $a['module'] = TextHelper::clear($a['module']);
        if (!$a['module_id'] && $a['module'])
            $a['module_id'] = $a['module'];

        $a['advertiser'] = \sanitize_text_field($a['advertiser']);
        $a['advertiser_id'] = \sanitize_text_field($a['advertiser_id']);
        $a['id'] = (int) $a['id'];
        if (!$a['advertiser_id'] && $a['advertiser'])
            $a['advertiser_id'] = $a['advertiser'];
        if (!$a['advertiser_id'] && $a['id'])
            $a['advertiser_id'] = $a['id'];

        return $a;
    }

    public function shop($atts, $content = '')
    {
        $a = $this->prepareAttr($atts);

        if (!$a['advertiser_id'])
            return;
        if (!$a['display'])
            $a['display'] = 'site_url';

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

        $display = $a['display'];

        $viewer = AdvertiserViewer::getInstanceByAdvertiser($advertiser['module_id'], $advertiser['id']);

        if ($display == 'commission')
            return Commission::displayAdvertiserComission($advertiser);

        if ($display == 'cashback')
            return $viewer->getCashback($advertiser);

        if ($display == 'cashbackmax')
            return $viewer->getCashbackMax($advertiser);

        if ($display == 'tracking_link')
            return $viewer->getTrackingLink($advertiser);

        if ($r = $viewer->getData($display))
            return \esc_html($r);
    }
}
