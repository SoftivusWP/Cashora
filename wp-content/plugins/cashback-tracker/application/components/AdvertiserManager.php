<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\helpers\ArrayHelper;

/**
 * AdvertiserManager class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdvertiserManager
{

    const OPTION_NAME = 'cbtrkr_advertisers';

    private static $instance;
    protected static $advertisers = array();

    private function __construct()
    {
        $this->init();
    }

    public static function getInstance()
    {
        if (self::$instance === null)
            self::$instance = new self;
        return self::$instance;
    }

    private function init()
    {
        self::$advertisers = \get_option(self::OPTION_NAME, array());
    }

    public function getAdvertiser($module_id, $advertiser_id, $forced = false)
    {
        if (isset(self::$advertisers[$module_id][$advertiser_id]))
            $advertiser = self::$advertisers[$module_id][$advertiser_id];
        else
            $advertiser = null;

        // request if not exists or forced
        if ($advertiser === null || (!$advertiser && $forced))
        {
            $advertiser = array();
            $module = ModuleManager::factory($module_id);
            try
            {
                if ($advertiser = $module->getAdvertiser($advertiser_id))
                {
                    $advertiser = ArrayHelper::object2Array($advertiser);
                    $advertiser['module_id'] = $module_id;
                }
            }
            catch (\Exception $e)
            {
                Plugin::logger()->info(sprintf($module_id . ':' . 'Error occurred while getting advertiser info. Advertiser ID# %d.'), $advertiser_id);
            }

            if (!isset(self::$advertisers[$module_id]))
                self::$advertisers[$module_id] = array();
            self::$advertisers[$module_id][$advertiser_id] = $advertiser;

            // update db
            \update_option(self::OPTION_NAME, self::$advertisers);
        }
        return $advertiser;
    }

    public function getAdvertisers($module_id, $forced = false)
    {
        if (isset(self::$advertisers[$module_id]))
            $advertisers = self::$advertisers[$module_id];
        else
            $advertisers = null;

        if ($advertisers === null || $forced)
        {
            $advertisers = array();
            $module = ModuleManager::factory($module_id);
            try
            {
                if ($advertisers = $module->getAdvertisers())
                {
                    $advertisers = ArrayHelper::object2Array($advertisers);
                    foreach ($advertisers as $i => $advertiser)
                    {
                        $advertisers[$i]['module_id'] = $module_id;
                    }
                }
                self::$advertisers[$module_id] = $advertisers;
            }
            catch (\Exception $e)
            {
                Plugin::logger()->info($module_id . ': ' . 'Error occurred while getting advertiser list.');
                if (!isset(self::$advertisers[$module_id]))
                    self::$advertisers[$module_id] = array();
            }

            // update db
            if (self::$advertisers || !\get_option(self::OPTION_NAME, array()))
            {
                \update_option(self::OPTION_NAME, self::$advertisers);
                $this->setDownloadDate($module_id);
            }
        }

        return self::$advertisers[$module_id];
    }

    public function getAllAdvertisers($only_active = true)
    {
        $module_ids = ModuleManager::getInstance()->getModulesIdList($only_active);
        $all_advertisers = array();
        foreach ($module_ids as $module_id)
        {
            $advertisers = $this->getAdvertisers($module_id);
            foreach ($advertisers as $advertiser)
            {
                if ($advertiser)
                    $all_advertisers[] = $advertiser;
            }
        }
        return $all_advertisers;
    }

    public function findAdvertiserByDomain($domain, $module_id = null)
    {
        if (!$module_id)
            return self::findAdvertiserByDomainOnly($domain);

        if (empty(self::$advertisers[$module_id]))
            return false;

        foreach (self::$advertisers[$module_id] as $advertiser)
        {
            if ($advertiser['domain'] == $domain)
            {
                $advertiser['module_id'] = $module_id;
                return $advertiser;
            }
        }
    }

    public function findAdvertiserByDomainOnly($domain)
    {
        foreach (self::$advertisers as $module_id => $advertisers)
        {
            foreach ($advertisers as $advertiser)
            {
                if (!empty($advertiser['domain']) && $advertiser['domain'] == $domain)
                {
                    $advertiser['module_id'] = $module_id;
                    return $advertiser;
                }
            }
        }
        return false;
    }

    public function findAdvertiserById($advertiser_id, $module_id = null)
    {
        if (!$module_id)
            return self::findAdvertiserByIdOnly($advertiser_id);

        if (empty(self::$advertisers[$module_id]))
            return false;

        if (isset(self::$advertisers[$module_id][$advertiser_id]))
        {
            $advertiser = self::$advertisers[$module_id][$advertiser_id];
            $advertiser['module_id'] = $module_id;
            return $advertiser;
        }
    }

    public function findAdvertiserByIdOnly($advertiser_id)
    {
        foreach (self::$advertisers as $module_id => $advertisers)
        {
            if (isset($advertisers[$advertiser_id]))
            {
                if (!$advertisers[$advertiser_id])
                    return false;

                $advertiser = $advertisers[$advertiser_id];
                $advertiser['module_id'] = $module_id;
                return $advertiser;
            }
        }
        return false;
    }

    public function findAdvertiserByName($name, $module_id)
    {
        if (empty(self::$advertisers[$module_id]))
            return false;

        foreach (self::$advertisers[$module_id] as $advertiser)
        {
            if ($advertiser['name'] == $name)
                return $advertiser;
        }

        return false;
    }

    public function setDownloadDate($module_id)
    {
        \update_option('cbtrkr_last_download_date_' . $module_id, time());
    }

    public function getDownloadDate($module_id)
    {
        return \get_option('cbtrkr_last_download_date_' . $module_id, null);
    }

    public function advertiserCount($module_id)
    {
        if (empty(self::$advertisers[$module_id]))
            return 0;
        $count = 0;
        foreach (self::$advertisers[$module_id] as $advertiser)
        {
            if ($advertiser)
                $count++;
        }
        return $count;
    }

    public function advertiserExists($module_id, $advertiser_id)
    {
        if ($this->getAdvertiser($module_id, $advertiser_id))
            return true;
        else
            return false;
    }

    public static function initHooks()
    {
        \add_action('cbtrkr_refresh_advertisers', array(__CLASS__, 'refreshAdvertisers'), 10, 1);
    }

    public static function refreshAdvertisers($module_id)
    {
        //error_log('refreshAdvertisers -> ' . $module_id);

        if (!ModuleManager::getInstance()->moduleExists($module_id))
            return;

        AdvertiserManager::getInstance()->getAdvertisers($module_id, true);
    }
}
