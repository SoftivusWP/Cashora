<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\models\OrderModel;

/**
 * OrderUserController class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class OrderUserController
{

    public function page_slug()
    {
        return Plugin::slug . '-user-orders';
    }

    public function __construct()
    {
        // for users only
        if (\current_user_can('administrator'))
            return;
        \add_action('admin_menu', array($this, 'add_admin_menu'));
        \add_action('admin_init', array($this, 'remove_http_referer'));
    }

    public function remove_http_referer()
    {
        global $pagenow;
        if ($pagenow == 'admin.php' && isset($_GET['page']) && $_GET['page'] == $this->page_slug() && !empty($_GET['_wp_http_referer']))
        {
            \wp_redirect(\remove_query_arg(array('_wp_http_referer', '_wpnonce'), \wp_unslash($_SERVER['REQUEST_URI'])));
            exit;
        }
    }

    public function add_admin_menu()
    {
        \add_menu_page(__('My orders', 'cashback-tracker') . ' &lsaquo; ' . Plugin::getName(), __('My orders', 'cashback-tracker'), 'read', $this->page_slug(), array($this, 'actionIndex'));
    }

    public function actionIndex()
    {
        $table = new OrderUserTable(OrderModel::model());
        $table->prepare_items();
        PluginAdmin::getInstance()->render('order_user_index', array('table' => $table));
    }
}
