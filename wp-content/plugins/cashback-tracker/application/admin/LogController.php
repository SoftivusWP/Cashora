<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\models\LogModel;

/**
 * LogController class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class LogController
{

    public function page_slug()
    {
        return Plugin::slug . '-logs';
    }

    public function __construct()
    {
        \add_action('admin_menu', array($this, 'add_admin_menu'));
    }

    public function add_admin_menu()
    {
        \add_submenu_page(Plugin::slug, __('Logs', 'cashback-tracker') . ' &lsaquo; ' . Plugin::getName(), __('Logs', 'cashback-tracker'), 'manage_options', $this->page_slug(), array($this, 'actionIndex'));
    }

    public function actionIndex()
    {
        $table = new LogTable(LogModel::model());
        $table->prepare_items();
        PluginAdmin::getInstance()->render('log_index', array('table' => $table));
    }
}
