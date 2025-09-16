<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\models\CouponModel;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\admin\ShopMetabox;
use CashbackTracker\application\admin\CouponConfig;
use CashbackTracker\application\helpers\TextHelper;

/**
 * CouponManager class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CouponManager
{

    private static $instance;

    const META_LAST_UPDATE = '_cbtrkr_coupons_update';
    const TYPE_DEAL = 0;
    const TYPE_COUPON = 1;

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new self;

        return self::$instance;
    }

    public function updateCoupons($page_id)
    {
        $module_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'module_id', true);
        $advertiser_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'advertiser_id', true);

        if (!ModuleManager::getInstance()->moduleExists($module_id) || !ModuleManager::getInstance()->isModuleActive($module_id))
            return false;

        $module = ModuleManager::getInstance()->factory($module_id);

        try
        {
            $coupons = $module->getCoupons($advertiser_id);
        }
        catch (\Exception $e)
        {
            $this->setUpdateDate($module_id, $advertiser_id);

            Plugin::logger()->warning($module->getId() . ' error: ' . $e->getMessage());
            return false;
        }

        if (!$coupons)
            $coupons = array();

        $advertiser = AdvertiserManager::getInstance()->getAdvertiser($module_id, $advertiser_id);
        $log = sprintf($module->getId() . ': ' . __('%s coupons has been updated.', 'cashback-tracker'), $advertiser['domain']);
        $log .= ' ' . sprintf(__('Found coupons: %d.', 'cashback-tracker'), count($coupons));
        Plugin::logger()->debug($log);

        $this->saveCoupons($page_id, $coupons);

        return $coupons;
    }

    public function findCouponsByPage($page_id)
    {
        $module_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'module_id', true);
        $advertiser_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'advertiser_id', true);

        return $this->findCouponsByAdv($module_id, $advertiser_id);
    }

    public function findCouponsByAdv($module_id, $advertiser_id)
    {
        $params = array(
            'select' => '*',
            'where' => array('module_id = %s AND advertiser_id = %d', array($module_id, $advertiser_id)),
            //'order' => 'end_date ASC',
        );

        $coupons = CouponModel::model()->findAll($params);
        $coupons = self::prepareCoupons($coupons);

        return $coupons;
    }

    static public function prepareCoupons(array $coupons)
    {
        for ($i = 0; $i < count($coupons); $i++)
        {
            $coupons[$i]['extra'] = \maybe_unserialize($coupons[$i]['extra']);

            if ($coupons[$i]['start_date'] == '0000-00-00 00:00:00')
                $coupons[$i]['start_date'] = '';
            else
                $coupons[$i]['start_date'] = strtotime($coupons[$i]['start_date']);

            if ($coupons[$i]['end_date'] == '0000-00-00 00:00:00')
                $coupons[$i]['end_date'] = '';
            else
                $coupons[$i]['end_date'] = strtotime($coupons[$i]['end_date']);

            $advertiser = AdvertiserManager::getInstance()->getAdvertiser($coupons[$i]['module_id'], $coupons[$i]['advertiser_id']);

            if (!$advertiser)
            {
                unset($coupons[$i]);
                continue;
            }

            $coupons[$i]['adv_name'] = $advertiser['name'];
            $coupons[$i]['adv_domain'] = $advertiser['domain'];

            // make coupon links trackable
            $coupons[$i]['link'] = DeeplinkGenerator::maybeAddTracking($coupons[$i]['link']);
        }

        return $coupons;
    }

    static public function prepareAdvertiserIds(array $advertiser_ids, $module_id = null)
    {
        $ids = array();
        foreach ($advertiser_ids as $advertiser_id)
        {
            if (is_numeric($advertiser_id))
            {
                $advertiser = AdvertiserManager::getInstance()->findAdvertiserById($advertiser_id, $module_id);
            }
            else
            {
                if (!$domain = TextHelper::getHostName($advertiser_id))
                    $domain = TextHelper::getDomainWithoutSubdomain($advertiser_id);
                $advertiser = AdvertiserManager::getInstance()->findAdvertiserByDomain($domain, $module_id);
            }

            if (!$advertiser)
                continue;

            if (!ModuleManager::getInstance()->moduleExists($advertiser['module_id']) || !ModuleManager::getInstance()->isModuleActive($advertiser['module_id']))
                continue;

            $ids[] = $advertiser['id'];
        }

        return $ids;
    }

    public function updateIfNotExist($page_id)
    {
        $last_update = $this->getUpdateDate($page_id);
        if (!$last_update || $last_update <= 1)
            $this->updateCoupons($page_id);
    }

    public function saveCoupons($page_id, array $coupons)
    {
        $this->setUpdateDate($page_id);

        $module_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'module_id', true);
        $advertiser_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'advertiser_id', true);

        CouponModel::model()->deleteAll(array('module_id = %s AND advertiser_id = %d', array($module_id, $advertiser_id)));

        foreach ($coupons as $coupon)
        {
            $this->saveCoupon($page_id, $coupon);
        }
    }

    public function saveCoupon($page_id, Coupon $coupon)
    {
        $module_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'module_id', true);
        $advertiser_id = \get_post_meta($page_id, ShopMetabox::PREFIX . 'advertiser_id', true);

        $data = array(
            'module_id' => $module_id,
            'advertiser_id' => $advertiser_id,
            'code' => $coupon->code,
            'title' => $coupon->title,
            'link' => $coupon->link,
            'image' => $coupon->image,
            'description' => $coupon->description,
            'discount' => $coupon->discount,
            'extra' => $coupon->extra,
        );

        if ($data['code'])
            $data['type'] = CouponManager::TYPE_COUPON;
        else
            $data['type'] = CouponManager::TYPE_DEAL;

        if ($coupon->start_date)
            $data['start_date'] = date("Y-m-d H:m:s", $coupon->start_date);
        if ($coupon->end_date)
            $data['end_date'] = date("Y-m-d H:m:s", $coupon->end_date);

        CouponModel::model()->save($data);
    }

    public function setUpdateDate($page_id, $time = null)
    {
        if (!$time)
            $time = time();

        \update_post_meta($page_id, self::META_LAST_UPDATE, $time);
    }

    public function getUpdateDate($page_id)
    {
        return \get_post_meta($page_id, self::META_LAST_UPDATE, true);
    }

    public function getPerPageLimit()
    {
        return (int) CouponConfig::getInstance()->option('per_page');
    }
}
