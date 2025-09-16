<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\Metabox;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\AdvertiserPageManager;

/**
 * ShopMetabox class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ShopMetabox extends Metabox
{

    const PREFIX = '_cbtrkr_shop_';

    public function fields()
    {
        $prefix = self::PREFIX;
        return array(
            $prefix . 'module_id' => array(
                'title' => __('Module ID', 'cashback-tracker'),
                'description' => __('Set this parameter if you want to bind this page to a specific advertiser.', 'cashback-tracker') . ' ' . __('Example: Admitad or Awin.', 'cashback-tracker'),
                'filters' => array(
                    array($this, 'validateModuleId')
                ),
                'default' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(__('- select module -', 'cashback-tracker')) + array_combine(ModuleManager::getInstance()->getModulesIdList(true), ModuleManager::getInstance()->getModulesIdList(true)),
                //'readonly_if_set' => true,
            ),
            $prefix . 'advertiser_id' => array(
                'title' => __('Advertiser ID', 'cashback-tracker'),
                'description' => __('Set this parameter if you want to bind this page to a specific advertiser.', 'cashback-tracker') . ' ' . __('Example: 6115.', 'cashback-tracker'),
                'default' => '',
                'filters' => array(
                    'trim',
                    'allow_empty',
                    array($this, 'validateAdvertiserId')
                ),
                'callback' => array($this, 'render_input'),
                //'readonly_if_set' => true,
            ),
            $prefix . 'name' => array(
                'title' => __('Name', 'cashback-tracker'),
                'description' => __('Advertiser name.', 'cashback-tracker'),
                'default' => '',
                'callback' => array($this, 'render_input'),
            ),
            $prefix . 'domain' => array(
                'title' => __('Domain', 'cashback-tracker'),
                'description' => __('Advertiser domain.', 'cashback-tracker'),
                'default' => '',
                'placeholder' => 'example.com',
                'callback' => array($this, 'render_input'),
            ),
            $prefix . 'cashback' => array(
                'title' => __('Cashback notice', 'cashback-tracker'),
                'description' => __('Example: Up to 15% or $1-$5.', 'cashback-tracker'),
                'default' => '',
                'callback' => array($this, 'render_input'),
            ),
            $prefix . 'validation_days' => array(
                'title' => __('Validation days', 'cashback-tracker'),
                'description' => __('Average order validation time.', 'cashback-tracker'),
                'default' => '',
                'filters' => array(
                    'trim',
                    'allow_empty',
                    'allow_pattern',
                    'absint',
                ),
                'callback' => array($this, 'render_input'),
            ),
            $prefix . 'area_sidebar' => array(
                'title' => __('Sidebar area', 'cashback-tracker'),
                'description' => __('This is additional custom area for sidebar.', 'cashback-tracker')
                    . ' ' . __('You can use HTML tags here.', 'cashback-tracker'),
                'default' => '',
                'filters' => array(
                    '\wp_kses_post'
                ),
                'callback' => array($this, 'render_textarea'),
            ),
        );
    }

    public function addMetabox()
    {
        \add_meta_box('cbtrkr_shop', __('Shop Info', 'cashback-tracker'), array($this, 'renderMetabox'), 'cbtrkr_shop', 'advanced', 'default');
    }

    public function validateModuleId($module_id)
    {
        if (ModuleManager::getInstance()->moduleExists($module_id))
            return $module_id;
        else
            return '';
    }

    public function validateAdvertiserId($advertiser_id)
    {
        $advertiser_id = absint($advertiser_id);
        if (!empty($this->save['_cbtrkr_shop_module_id']))
            $module_id = $this->save['_cbtrkr_shop_module_id'];
        else
            $module_id = null;

        $return = '';
        if (is_numeric($advertiser_id))
        {
            // request if not exists
            if ($module_id)
            {
                if (AdvertiserManager::getInstance()->getAdvertiser($module_id, $advertiser_id))
                    $return = $advertiser_id;
                else
                    $return = '';
            }

            // find by ID
            if ($advertiser = AdvertiserManager::getInstance()->findAdvertiserById($advertiser_id))
            {
                $this->save['_cbtrkr_shop_module_id'] = $advertiser['module_id'];
                $return = $advertiser_id;
            }
        }
        else
        {
            // find by domain
            if (!$domain = TextHelper::getHostName($advertiser_id))
                $domain = TextHelper::getDomainWithoutSubdomain($advertiser_id);
            if ($advertiser = AdvertiserManager::getInstance()->findAdvertiserByDomain($domain, $module_id))
            {
                $this->save['_cbtrkr_shop_module_id'] = $advertiser['module_id'];
                $return = $advertiser['id'];
            }
        }

        // exists?
        if ($return)
        {
            $page_id = AdvertiserPageManager::getInstance()->getPageId($this->save['_cbtrkr_shop_module_id'], $return);
            if ($page_id && $page_id != $this->post_id)
                $return = '';
        }

        return $return;
    }
}
