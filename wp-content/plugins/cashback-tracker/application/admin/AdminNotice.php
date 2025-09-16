<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;

/**
 * AdminNotice class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdminNotice
{

    const GET_NOTICE_PARAM = 'ctraker-notice';
    const GET_LEVEL_PARAM = 'ctraker-notice-level';
    const GET_ID_PARAM = 'ctraker-notice-id';

    protected static $instance = null;

    public function getMassages()
    {
        return array(
            'license_reset_error' => __('License can not be deactivated.', 'cashback-tracker') . sprintf(__('Please <a href="%s" target="_blank">contact</a> our support team.', 'cashback-tracker'), \esc_url(Plugin::supportUri)),
            'license_reset_success' => __('License has been deactivated on this site.', 'cashback-tracker') . ' ' . sprintf(__('You must deactivate and delete %s plugin from the current site to be able to activate it on another one.', 'cashback-tracker'), Plugin::getName()),
            'loading_orders_done' => __('Loading of orders is done.', 'cashback-tracker'),
            'loading_advertisers_planned' => __('Advertisers are scheduled to load in the background.', 'cashback-tracker'),
            'loading_advertisers_done' => __('Loading of advertisers is done.', 'cashback-tracker'),
            'create_advertiser_page_error' => __('An error occurred while creating advertiser page.', 'cashback-tracker'),
            'pages_creation_complete' => __('The creation of all pages is complete.', 'cashback-tracker'),
        );
    }

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    private function __construct()
    {
    }

    public function adminInit()
    {
        \add_action('admin_notices', array($this, 'displayNotice'));
    }

    public function getMessage($message_id = null)
    {
        if (!$message_id && !empty($_GET[self::GET_NOTICE_PARAM]))
            $message_id = $_GET[self::GET_NOTICE_PARAM];
        else
            return '';

        $all = $this->getMassages();
        if (!array_key_exists($message_id, $all))
            return '';

        $message = $all[$message_id];

        if (!empty($_GET[self::GET_ID_PARAM]))
        {
            $id = (int) $_GET[self::GET_ID_PARAM];
            $message = str_replace('%%ID%%', $id, $message);
        }

        return $message;
    }

    public function displayNotice()
    {
        if (empty($_GET[self::GET_NOTICE_PARAM]))
            return;

        $level = 'info';
        if (!empty($_GET[self::GET_LEVEL_PARAM]))
        {
            $level = $_GET[self::GET_LEVEL_PARAM];
            if (!in_array($level, array('error', 'warning', 'info', 'success')))
                $level = 'info';
        }
        echo '<div class="notice notice-' . $level . ' is-dismissible"><p>' . $this->getMessage() . '</p></div>';
    }

    public static function add2Url($url, $message, $level = null, $id = null)
    {
        $url = add_query_arg(self::GET_NOTICE_PARAM, $message, $url);
        if ($level)
            $url = add_query_arg(self::GET_LEVEL_PARAM, $level, $url);
        if ($id)
            $url = add_query_arg(self::GET_ID_PARAM, $id, $url);
        return $url;
    }
}
