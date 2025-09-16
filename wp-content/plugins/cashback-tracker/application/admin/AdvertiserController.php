<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;

/**
 * AdvertiserController class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdvertiserController
{

    public function page_slug()
    {
        return Plugin::slug . '-advertisers';
    }

    public function __construct()
    {
        \add_action('admin_menu', array($this, 'add_admin_menu'));
        \add_action('admin_init', array($this, 'remove_http_referer'));
    }

    public function remove_http_referer()
    {
        global $pagenow;
        if ($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == Plugin::slug . '-advertisers' && !empty($_GET['_wp_http_referer']))
        {
            \wp_redirect(\remove_query_arg(array('_wp_http_referer', '_wpnonce'), \wp_unslash($_SERVER['REQUEST_URI'])));
            exit;
        }
    }

    public function add_admin_menu()
    {
        \add_submenu_page(Plugin::slug, __('Advertisers', 'cashback-tracker') . ' &lsaquo; ' . Plugin::getName(), __('Advertisers', 'cashback-tracker'), 'manage_options', $this->page_slug(), array($this, 'actionIndex'));
    }

    public function actionIndex()
    {
        \wp_enqueue_script('cbtrkr-blockUI', \CashbackTracker\PLUGIN_RES . '/js/jquery.blockUI.js', array('jquery'));

        $table = new AdvertiserTable();
        $table->prepare_items();
        PluginAdmin::getInstance()->render('advertiser_index', array('table' => $table));
    }
}
