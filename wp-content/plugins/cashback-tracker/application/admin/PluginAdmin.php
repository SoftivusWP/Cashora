<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\ModuleManager;
use CashbackTracker\application\admin\ShopMetabox;
use CashbackTracker\application\components\LManager;
use CashbackTracker\application\ModuleScheduler;
use CashbackTracker\application\CouponScheduler;

/**
 * PluginAdmin class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class PluginAdmin
{

    protected static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    private function __construct()
    {
        if (!\is_admin())
            die('You are not authorized to perform the requested action.');

        \add_action('admin_menu', array($this, 'add_admin_menu'));
        \add_action('admin_enqueue_scripts', array($this, 'admin_load_scripts'));
        \add_filter('parent_file', array($this, 'highlight_admin_menu'));

        AdminNotice::getInstance()->adminInit();
        LManager::getInstance()->adminInit();

        if (Plugin::isFree() || (Plugin::isPro() && Plugin::isActivated()) || Plugin::isEnvato())
        {
            GeneralConfig::getInstance()->adminInit();
            CouponConfig::getInstance()->adminInit();
            ModuleManager::getInstance()->adminInit();

            new OrderController;
            new OrderUserController;
            new AdvertiserController;
            new LogController;
            new ToolsController;
            $metabox = new ShopMetabox();
            $metabox->adminInit();

            ModuleScheduler::addScheduleEvent();
            CouponScheduler::addScheduleEvent();
        }

        if (Plugin::isEnvato() && !Plugin::isActivated() && !\get_option(Plugin::slug . '_env_install'))
            EnvatoConfig::getInstance()->adminInit();
        elseif (Plugin::isPro())
            LicConfig::getInstance()->adminInit();
        if (Plugin::isPro() && Plugin::isActivated())
            new \CashbackTracker\application\Autoupdate(Plugin::version(), \plugin_basename(\CashbackTracker\PLUGIN_FILE), Plugin::getApiBase(), Plugin::slug);
    }

    function admin_load_scripts()
    {

        if ($GLOBALS['pagenow'] != 'admin.php' || empty($_GET['page']))
            return;

        $page_pats = explode('-', $_GET['page']);

        if (count($page_pats) < 2 || $page_pats[0] . '-' . $page_pats[1] != Plugin::slug())
            return;

        \wp_enqueue_style(Plugin::slug() . '-admin', \CashbackTracker\PLUGIN_RES . '/css/admin.css', array(), Plugin::version());
        \wp_enqueue_script(Plugin::getSlug() . '-admin', \CashbackTracker\PLUGIN_RES . '/js/admin.js', array('jquery'), Plugin::version());
    }

    public function add_admin_menu()
    {
        $icon_svg = 'dashicons-undo';
        \add_menu_page(Plugin::getName(), Plugin::getName(), 'publish_posts', Plugin::getSlug(), null, $icon_svg);
    }

    public static function render($view_name, $_data = null)
    {
        if (is_array($_data))
            extract($_data, EXTR_PREFIX_SAME, 'data');
        else
            $data = $_data;

        include \CashbackTracker\PLUGIN_PATH . 'application/admin/views/' . PluginAdmin::sanitize($view_name) . '.php';
    }

    /**
     * Highlight menu for hidden submenu item
     */
    function highlight_admin_menu($file)
    {
        global $plugin_page;

        // options.php - hidden submenu items
        if ($file != 'options.php' || substr($plugin_page, 0, strlen(Plugin::slug())) !== Plugin::slug())
            return $file;

        $page_parts = explode('--', $plugin_page);
        if (count($page_parts) > 1)
        {
            $plugin_page = $page_parts[0];
        }
        else
            $plugin_page = Plugin::slug();

        return $file;
    }

    static public function sanitize($str)
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $str);
    }
}
