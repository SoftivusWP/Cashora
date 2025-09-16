<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\logger\Logger;
use CashbackTracker\application\admin\GeneralConfig;
use CashbackTracker\application\bridges\mycred\MycredBridge;
use CashbackTracker\application\ModuleScheduler;
use CashbackTracker\application\TrackingLinkShortcode;
use CashbackTracker\application\components\ShopPostType;
use CashbackTracker\application\components\TemplateManager;
use CashbackTracker\application\components\AdvertiserManager;
use CashbackTracker\application\components\ShopTaxonomy;
use CashbackTracker\application\CouponShortcode;

use function CashbackTracker\prn;
use function CashbackTracker\prnx;

/**
 * Plugin class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class Plugin
{
    const version = '2.8.8';
    const db_version = 25;
    const wp_requires = '4.9.7';
    const php_requires = '5.6.38';
    const slug = 'cashback-tracker';
    const short_slug = 'cbtrkr';
    const name = 'Cashback Tracker';
    const website = 'https://www.keywordrush.com';
    const api_base = 'https://www.keywordrush.com/api/v1';
    const api_base2 = '';
    const supportUri = 'https://www.keywordrush.com/contact';
    const panelUri = 'https://www.keywordrush.com/panel';
    const product_id = 303;

    private static $instance = null;
    private static $is_pro = null;
    private static $is_envato = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    public static function registerComponents()
    {
        // Register widgets early
        \add_action('widgets_init', function ()
        {
            \register_widget(\CashbackTracker\application\CouponWidget::class);
            \register_widget(\CashbackTracker\application\ShopWidget::class);
        });

        // Register custom post type early
        \add_action('init', ['\CashbackTracker\application\components\ShopPostType', 'registerPostType'], 0);
    }

    private function __construct()
    {
        $this->loadTextdomain();

        AdvertiserManager::initHooks();
        self::initLogger();

        if (self::isFree() || (self::isPro() && self::isActivated()) || self::isEnvato())
        {
            if (!\is_admin())
            {
                \add_action('wp_enqueue_scripts', array($this, 'registerScripts'));
                TrackingLinkShortcode::getInstance();
                CashbackAdvertiser::getInstance();
                ShopsShortcode::getInstance();
                CouponShortcode::getInstance();
                AdvertiserPage::getInstance();
            }
            MycredBridge::getInstance()->init();
            WooTracking::init();
            CouponViewer::init();
        }
        ModuleScheduler::initAction();
        CouponScheduler::initAction();
    }

    static public function version()
    {
        return self::version;
    }

    static public function slug()
    {
        return self::getSlug();
    }

    static public function getName()
    {
        return self::name;
    }

    public static function getApiBase()
    {
        return self::api_base;
    }

    public static function isFree()
    {
        return !self::isPro();
    }

    public static function isPro()
    {
        if (self::$is_pro === null)
        {
            if (class_exists("\\CashbackTracker\\application\\Autoupdate", true))
                self::$is_pro = true;
            else
                self::$is_pro = false;
        }
        return self::$is_pro;
    }

    public static function isEnvato()
    {
        if (self::$is_envato === null)
        {
            if (isset($_SERVER['KEYWORDRUSH_DEVELOPMENT']) && $_SERVER['KEYWORDRUSH_DEVELOPMENT'] == '16203273895503427')
                self::$is_envato = false;
            elseif (class_exists("\\CashbackTracker\\application\\admin\\EnvatoConfig", true) || \get_option(Plugin::slug . '_env_install'))
                self::$is_envato = true;
            else
                self::$is_envato = false;
        }
        return self::$is_envato;
    }

    public static function isActivated()
    {
        if (self::isPro() && \CashbackTracker\application\admin\LicConfig::getInstance()->option('license_key'))
            return true;
        else
            return false;
    }

    public static function isInactiveEnvato()
    {
        if (self::isEnvato() && !self::isActivated())
            return true;
        else
            return false;
    }

    public static function apiRequest($params = array())
    {
        $api_urls = array(self::api_base);
        if (self::api_base2)
            $api_urls[] = self::api_base2;

        foreach ($api_urls as $api_url)
        {
            $response = \wp_remote_post($api_url, $params);
            if (\is_wp_error($response))
                continue;

            $response_code = (int) \wp_remote_retrieve_response_code($response);
            if ($response_code == 200)
                return $response;
            else
                return false;
        }
        return false;
    }

    public function loadTextdomain()
    {
        \load_plugin_textdomain('cashback-tracker', false, dirname(\plugin_basename(\CashbackTracker\PLUGIN_FILE)) . '/languages/');
    }

    public static function getSlug()
    {
        return self::slug;
    }

    public static function getShortSlug()
    {
        return self::short_slug;
    }

    public static function getWebsite()
    {
        return self::website;
    }

    public static function getDocsUrl()
    {
        return 'https://ctracker-docs.keywordrush.com/';
    }

    public static function logger()
    {
        return Logger::getInstance();
    }

    public static function initLogger()
    {

        $logger = self::logger();

        $email_target = GeneralConfig::getInstance()->option('log_target_email');
        $levels = '';
        if ($email_target == 'error')
            $levels = array(Logger::LEVEL_ERROR);
        elseif ($email_target == 'warning_error')
            $levels = array(Logger::LEVEL_ERROR, Logger::LEVEL_WARNING);
        elseif ($email_target == 'all')
            $levels = '';
        else
        {
            $logger->getDispatcher()->targets['email']->enabled = false;
        }

        if ($logger->getDispatcher()->targets['email']->enabled)
        {
            $logger->getDispatcher()->targets['email']->levels = $levels;
            $logger->getDispatcher()->targets['email']->config['to'] = \get_bloginfo('admin_email');
        }

        //db
        $db_target = GeneralConfig::getInstance()->option('log_target_db');
        if ($db_target == 'all_without_debug')
            $levels = array(Logger::LEVEL_ERROR, Logger::LEVEL_INFO, Logger::LEVEL_WARNING);
        else
            $levels = array(Logger::LEVEL_DEBUG, Logger::LEVEL_ERROR, Logger::LEVEL_INFO, Logger::LEVEL_WARNING);
        if ($logger->getDispatcher()->targets['db']->enabled)
            $logger->getDispatcher()->targets['db']->levels = $levels;
    }

    public function registerScripts()
    {
        \wp_register_style('cbtrkr-frontend', \CashbackTracker\PLUGIN_RES . '/css/frontend.css', array(), Plugin::version() . '111');
        \wp_register_script('cbtrkr-frontend', \CashbackTracker\PLUGIN_RES . '/js/frontend.js', array('jquery'), null, false);
        if (!GeneralConfig::getInstance()->option('dequeue_style'))
            TemplateManager::getInstance()->enqueueFrontendStyle();
    }
}
