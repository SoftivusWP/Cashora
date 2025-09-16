<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\admin\LicConfig;
use CashbackTracker\application\ModuleScheduler;
use CashbackTracker\application\CouponScheduler;
use CashbackTracker\application\components\ShopPostType;

/**
 * Installer class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class Installer
{

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    private function __construct()
    {

        if (!empty($GLOBALS['pagenow']) && $GLOBALS['pagenow'] == 'plugins.php')
        {
            \add_action('admin_init', array($this, 'requirements'), 0);
        }

        \add_action('admin_init', array($this, 'upgrade'));
        \add_action('admin_init', array($this, 'redirect_after_activation'));
    }

    static public function dbVesrion()
    {
        return Plugin::db_version;
    }

    public static function activate()
    {
        if (!\current_user_can('activate_plugins'))
            return;

        self::requirements();

        ModuleScheduler::addScheduleEvent();
        CouponScheduler::addScheduleEvent();

        \add_option(Plugin::slug . '_do_activation_redirect', true);
        \add_option(Plugin::slug . '_first_activation_date', time());
        self::upgradeTables();

        ShopPostType::registerPostType();
        \flush_rewrite_rules();
    }

    public static function deactivate()
    {
        ModuleScheduler::clearScheduleEvent();
        CouponScheduler::clearScheduleEvent();
    }

    public static function requirements()
    {
        $extensions = array(
            //'simplexml',
        );

        $errors = array();
        $name = Plugin::getName();

        global $wp_version;
        if (version_compare(Plugin::wp_requires, $wp_version, '>'))
            $errors[] = sprintf('You are using Wordpress %s. <em>%s</em> requires at least <strong>Wordpress %s</strong>.', $wp_version, $name, Plugin::wp_requires);

        $php_current_version = phpversion();
        if (version_compare(Plugin::php_requires, $php_current_version, '>'))
            $errors[] = sprintf('PHP is installed on your server %s. <em>%s</em> requires at least <strong>PHP %s</strong>.', $php_current_version, $name, Plugin::php_requires);

        foreach ($extensions as $extension)
        {
            if (!extension_loaded($extension))
                $errors[] = sprintf('Requires extension <strong>%s</strong>.', $extension);
        }
        if (!$errors)
            return;
        unset($_GET['activate']);
        \deactivate_plugins(\plugin_basename(\CashbackTracker\PLUGIN_FILE));
        $e = sprintf('<div class="error"><p>%1$s</p><p><em>%2$s</em> ' . 'cannot be installed!' . '</p></div>', join('</p><p>', $errors), $name);
        \wp_die($e);
    }

    public static function uninstall()
    {
        if (!\current_user_can('activate_plugins'))
            return;

        \delete_option(Plugin::slug . '_db_version');
        if (Plugin::isEnvato())
            \delete_option(Plugin::slug . '_env_install');
        if (Plugin::isPro())
            \delete_option(LicConfig::getInstance()->option_name());
    }

    public static function upgrade()
    {
        $db_version = \get_option(Plugin::slug . '_db_version');

        if ((int) $db_version >= (int) self::dbVesrion())
            return;
        self::upgradeTables();

        \update_option(Plugin::slug . '_db_version', self::dbVesrion());
    }

    private static function upgradeTables()
    {
        $models = array('LogModel', 'OrderModel', 'CouponModel');
        $sql = '';
        foreach ($models as $model)
        {
            $m = "\\CashbackTracker\\application\\models\\" . $model;
            $sql .= $m::model()->getDump();
            $sql .= "\r\n";
        }
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        \dbDelta($sql);
    }

    public function redirect_after_activation()
    {
        if (\get_option(Plugin::slug . '_do_activation_redirect', false))
        {
            \delete_option(Plugin::slug . '_do_activation_redirect');
            \wp_redirect(\get_admin_url(\get_current_blog_id(), 'admin.php?page=' . Plugin::slug));
        }
    }
}
