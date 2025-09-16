<?php

namespace CashbackTracker\application\admin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\Plugin;
use CashbackTracker\application\components\Config;

/**
 * GeneralConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CouponConfig extends Config
{

    public function page_slug()
    {
        return Plugin::getSlug() . '-coupon';
    }

    public function option_name()
    {
        return Plugin::getSlug() . '_coupon';
    }

    public function add_admin_menu()
    {
        \add_submenu_page('options.php', __('Coupon settings', 'cashback-tracker') . ' &lsaquo; ' . Plugin::getName(), '', 'manage_options', $this->page_slug, array($this, 'settings_page'));
    }

    public function header_name()
    {
        return __('Coupons', 'cashback-tracker');
    }

    protected function options()
    {
        return array(
            'import_coupons' => array(
                'title' => __('Coupons import', 'cashback-tracker'),
                'description' => __('Import coupons to advertiser pages.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'enabled' => __('Enabled', 'cashback-tracker'),
                    'disabled' => __('Disabled', 'cashback-tracker'),
                ),
                'default' => 'enabled',
            ),
            'embed_at' => array(
                'title' => __('Coupons embedding', 'cashback-trackerg'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'bottom' => __('At the end of the post', 'cashback-tracker'),
                    'top' => __('At the beginning of the post', 'cashback-tracker'),
                ),
                'default' => 'bottom',
                'section' => 'default',
            ),
            'per_page' => array(
                'title' => __('Coupons per page', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => 50,
                'validator' => array(
                    'trim',
                    'absint',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'less_than_equal_to'),
                        'arg' => 100,
                        'message' => sprintf(__('The field "%s" can not be more than %d.', 'cashback-tracker'), 'Results', 100),
                    ),
                ),
            ),
            'button_color' => array(
                'title' => __('Button color', 'cashback-tracker'),
                'callback' => array($this, 'render_color_picker'),
                'default' => '#d9534f',
                'validator' => array(
                    'trim',
                ),
            ),
            'button_text_coupon' => array(
                'title' => __('Button text coupons', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    '\sanitize_text_field',
                ),
            ),
            'button_text_deal' => array(
                'title' => __('Button text deals', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    '\sanitize_text_field',
                ),
            ),
            'show_exp_date' => array(
                'title' => __('Expiration date', 'cashback-tracker'),
                'description' => __('Show expiration date', 'cashback-tracker'),
                'callback' => array($this, 'render_checkbox'),
                'default' => true,
                'section' => 'default',
            ),
            'show_description' => array(
                'title' => __('Description', 'cashback-tracker'),
                'description' => __('Show description', 'cashback-tracker'),
                'callback' => array($this, 'render_checkbox'),
                'default' => true,
                'section' => 'default',
            ),
        );
    }

    public function settings_page()
    {
        PluginAdmin::getInstance()->render('settings', array('page_slug' => $this->page_slug()));
    }
}
