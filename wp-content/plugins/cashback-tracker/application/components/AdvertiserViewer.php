<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\Advertiser;
use CashbackTracker\application\helpers\ArrayHelper;
use CashbackTracker\application\admin\ShopMetabox;

/**
 * AdvertiserViewer class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdvertiserViewer
{

    const POINTER_TYPE_BY_PAGE = 0;
    const POINTER_TYPE_BY_ADVERTISER = 1;

    private $advertisers = array();
    private $last_advertiser = array();
    private $pointer_by_page = array();
    private $pointer_by_advertiser = array();
    private static $instance = null;
    private static $metabox_fields = null;

    public static function getInstance()
    {
        $args = func_get_args();

        if (count($args) == 1)
            return self::getInstanceByPage($args[0]);
        elseif (count($args) == 2)
            return self::getInstanceByAdvertiser($args[0], $args[1]);
        else
            throw new \Exception("Wrong parameters count");
    }

    private function __construct()
    {
    }

    public static function getInstanceByPage($page_id)
    {
        if (self::$instance == null)
            self::$instance = new self;
        $obj = self::$instance;
        $obj->initByPage($page_id);
        return $obj;
    }

    public static function getInstanceByAdvertiser($module_id, $advertiser_id)
    {
        if (self::$instance == null)
            self::$instance = new self;
        $obj = self::$instance;
        $obj->initByAdvertiser($module_id, $advertiser_id);
        return $obj;
    }

    private function initByPage($page_id)
    {
        if (isset($this->pointer_by_page[$page_id]))
            return $this->last_advertiser = $this->advertisers[$this->pointer_by_page[$page_id]];

        $module_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'module_id', true);
        $advertiser_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'advertiser_id', true);

        return $this->init($module_id, $advertiser_id, $page_id);
    }

    private function initByAdvertiser($module_id, $advertiser_id)
    {
        $id = $module_id . '-' . $advertiser_id;
        if (isset($this->pointer_by_advertiser[$id]))
            return $this->last_advertiser = $this->advertisers[$this->pointer_by_advertiser[$id]];

        $page_id = AdvertiserPageManager::getInstance()->getPageId($module_id, $advertiser_id);
        return $this->init($module_id, $advertiser_id, $page_id);
    }

    private function init($module_id = null, $advertiser_id = null, $page_id = null)
    {
        $api_advertiser = $advertiser = null;
        if ($module_id && $advertiser_id)
        {
            $api_advertiser = AdvertiserManager::getInstance()->getAdvertiser($module_id, $advertiser_id);
            $advertiser = $api_advertiser;
        }

        if (!$advertiser)
        {
            $advertiser = ArrayHelper::object2Array(new Advertiser);
            array_walk($advertiser, function (&$value)
            {
                $value = '';
            });
            if (isset($advertiser['id']))
                unset($advertiser['id']);
        }

        if ($page_id)
            $advertiser = $this->applayPageDataToAdvertiser($advertiser, $page_id);

        $advertiser['advertiser_id'] = $advertiser_id;

        if ($api_advertiser)
        {
            if (empty($advertiser['cashback']))
                $advertiser['cashback'] = Commission::displayAdvertiserCashback($api_advertiser);
            $advertiser['tracking_link'] = DeeplinkGenerator::generateTrackingLink($api_advertiser['module_id'], $api_advertiser['id']);
        }

        $pointer = count($this->advertisers) + 1;
        $this->advertisers[$pointer] = $advertiser;
        $this->pointer_by_page[$page_id] = $pointer;
        if ($module_id && $advertiser_id)
            $this->pointer_by_advertiser[$module_id . '-' . $advertiser_id] = $pointer;

        $this->last_advertiser = $this->advertisers[$pointer];
        return $this->last_advertiser;
    }

    private function applayPageDataToAdvertiser(array $advertiser, $page_id)
    {
        $metafields = $this->getMetaFields();
        foreach ($metafields as $field)
        {
            $name = substr_replace($field, '', 0, strlen(ShopMetabox::PREFIX));
            if (strstr($name, 'area_'))
                continue;
            if ($value = \get_post_meta($page_id, $field, true))
                $advertiser[$name] = $value;
        }

        if ($thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id($page_id)))
            $advertiser['logo_url'] = $thumbnail_url;

        return $advertiser;
    }

    private function getMetaFields()
    {
        if (self::$metabox_fields == null)
        {
            $metabox = new ShopMetabox();
            self::$metabox_fields = $metabox->getFieldNames();
            if (isset(self::$metabox_fields['_cbtrkr_shop_module_id']))
                unset(self::$metabox_fields['_cbtrkr_shop_module_id']);
            if (isset(self::$metabox_fields['_cbtrkr_shop_advertiser_id']))
                unset(self::$metabox_fields['_cbtrkr_shop_advertiser_id']);
        }
        return self::$metabox_fields;
    }

    public function getData($field)
    {
        if (!empty($this->last_advertiser[$field]))
            return $this->last_advertiser[$field];
        else
            return '';
    }

    public function getModuleId()
    {
        return $this->getData('module_id');
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function getCashback()
    {
        return $this->getData('cashback');
    }

    public function getCashbackMax()
    {
        $cashback = $this->getData('cashback');
        $a = explode('-', $cashback);
        return trim(end($a));
    }

    public function getLogoUrl()
    {
        return $this->getData('logo_url');
    }

    public function getLogo()
    {
        return $this->getLogoUrl();
    }

    public function getDomain()
    {
        return $this->getData('domain');
    }

    public function getValidationDays()
    {
        return $this->getData('validation_days');
    }

    public function getTrackingLink()
    {
        return $this->getData('tracking_link');
    }

    public function getSiteUrl()
    {
        return $this->getData('site_url');
    }

    public function getExtra()
    {
        if ($extra = $this->getData('_extra'))
            return $extra;
        else
            return null;
    }

    public function getAdvertiser()
    {
        return $this->last_advertiser;
    }
}
