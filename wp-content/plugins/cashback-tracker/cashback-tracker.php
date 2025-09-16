<?php

namespace CashbackTracker;

/*
  Plugin Name: Cashback Tracker Pro
  Plugin URI: https://www.keywordrush.com/cashbacktracker
  Description: Plugin for creating tracking links and tracking statistic for cashback sites.
  Version: 2.8.8
  Author: keywordrush.com
  Author URI: https://www.keywordrush.com
  Text Domain: cashback-tracker
 */

/*
 * Copyright (c)  www.keywordrush.com  (email: support@keywordrush.com)
 */

defined('\ABSPATH') || die('No direct script access allowed!');

define(__NAMESPACE__ . '\NS', __NAMESPACE__ . '\\');
define(NS . 'PLUGIN_PATH', \plugin_dir_path(__FILE__));
define(NS . 'PLUGIN_FILE', __FILE__);
define(NS . 'PLUGIN_RES', \plugins_url('res', __FILE__));

require_once PLUGIN_PATH . 'loader.php';

\add_action('plugins_loaded', array('\CashbackTracker\application\Plugin', 'registerComponents'));
\add_action('init', array('\CashbackTracker\application\Plugin', 'getInstance'));

if (\is_admin())
{
  \register_activation_hook(__FILE__, array(\CashbackTracker\application\Installer::getInstance(), 'activate'));
  \register_deactivation_hook(__FILE__, array(\CashbackTracker\application\Installer::getInstance(), 'deactivate'));
  \register_uninstall_hook(__FILE__, array('\CashbackTracker\application\Installer', 'uninstall'));
  \add_action('init', array('\CashbackTracker\application\admin\PluginAdmin', 'getInstance'));
}
