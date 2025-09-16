<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\admin\GeneralConfig;
use CashbackTracker\application\helpers\WpHelper;
use CashbackTracker\application\admin\ShopMetabox;
use CashbackTracker\application\helpers\ImageHelper;
use CashbackTracker\application\components\Commission;

/**
 * AdvertiserPageManager class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdvertiserPageManager
{

    private static $instance;
    protected $pages = array();

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new self;
        return self::$instance;
    }

    public function getPageId($module_id, $advertiser_id)
    {
        if (!isset($this->pages[$module_id][$advertiser_id]))
        {
            $args = array(
                'numberposts' => 1,
                'post_type' => 'cbtrkr_shop',
                'suppress_filters' => true,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => '_cbtrkr_shop_module_id',
                        'value' => $module_id,
                        'compare' => '=',
                    ),
                    array(
                        'key' => '_cbtrkr_shop_advertiser_id',
                        'value' => $advertiser_id,
                        'compare' => '=',
                    ),
                ),
            );

            if (!$pages = \get_posts($args))
                $page_id = null;
            else
                $page_id = $pages[0]->ID;

            if (!isset($this->pages[$module_id]))
                $this->pages[$module_id] = array();

            $this->pages[$module_id][$advertiser_id] = $page_id;
        }

        return $this->pages[$module_id][$advertiser_id];
    }

    public function isPageExists($module_id, $advertiser_id)
    {
        if ($this->getPageId($module_id, $advertiser_id))
            return true;
        else
            return false;
    }

    public function createPage($module_id, $advertiser_id)
    {
        if (!$advertiser = AdvertiserManager::getInstance()->getAdvertiser($module_id, $advertiser_id))
            return false;

        if (GeneralConfig::getInstance()->option('advertiser_page_status') == 'publish')
            $page_status = 'publish';
        else
            $page_status = 'pending';

        $title = GeneralConfig::getInstance()->option('advertiser_page_title');
        $advertiser['cashback'] = Commission::displayAdvertiserCashback($advertiser_id, $module_id);
        $title = \sanitize_text_field(self::buildTemplate($title, $advertiser));
        if (!$title)
            $title = \sanitize_text_field($advertiser['name'] . ' ' . __('Cashback', 'cashback-tracker'));

        $user_id = WpHelper::getCurrentUserIdOrAdmin();

        // custom fields
        $meta_input = array();
        $meta_input[ShopMetabox::PREFIX . 'module_id'] = $module_id;
        $meta_input[ShopMetabox::PREFIX . 'advertiser_id'] = $advertiser_id;

        $post = array(
            'ID' => null,
            'post_title' => $title,
            'post_content' => '',
            'post_status' => $page_status,
            'post_author' => $user_id,
            'post_type' => 'cbtrkr_shop',
            'meta_input' => $meta_input,
        );

        if (!$page_id = \wp_insert_post($post))
            return false;

        if (!empty($advertiser['logo_url']))
        {
            $logo_title = $advertiser['domain'] . ' logo';
            if ($logo_path = ImageHelper::saveImgLocaly($advertiser['logo_url'], $logo_title, true, true))
                ImageHelper::attachThumbnail($logo_path, $page_id, $logo_title);
        }

        \do_action('cbtrkr_advertiser_page_create', $page_id);

        CouponManager::getInstance()->setUpdateDate($page_id, 1);

        return $page_id;
    }

    public static function buildTemplate($template, array $data)
    {
        if (!$template)
            return '';

        if (!preg_match_all('/%[a-zA-Z0-9_]+%/', $template, $matches))
            return $template;
        $replace = array();
        foreach ($matches[0] as $pattern)
        {
            $key = ltrim($pattern, '%');
            $key = rtrim($key, '%');
            $key = strtolower($key);
            if (array_key_exists($key, $data))
                $replace[$pattern] = $data[$key];
            else
                $replace[$pattern] = '';
        }

        return str_ireplace(array_keys($replace), array_values($replace), $template);
    }
}
