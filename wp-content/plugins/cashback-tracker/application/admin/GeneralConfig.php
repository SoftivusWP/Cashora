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
class GeneralConfig extends Config
{

    public function page_slug()
    {
        return Plugin::getSlug() . '';
    }

    public function option_name()
    {
        return Plugin::getSlug() . '-settings';
    }

    public function header_name()
    {
        return __('General settings', 'cashback-tracker');
    }

    public function add_admin_menu()
    {
        \add_submenu_page(Plugin::getSlug(), __('Settings', 'cashback-tracker') . ' &lsaquo; ' . Plugin::getName(), __('Settings', 'cashback-tracker'), 'manage_options', $this->page_slug, array($this, 'settings_page'));
    }

    protected function options()
    {
        return array(
            'mycred_integration' => array(
                'title' => __('myCRED integration', 'cashback-tracker'),
                'description' => sprintf(__('Integration with <a target="_blank" href="%s">myCRED plugin</a>.', 'cashback-tracker'), 'https://wordpress.org/plugins/mycred/'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'enabled' => __('Enabled', 'cashback-tracker'),
                    'disabled' => __('Disabled', 'cashback-tracker'),
                ),
                'default' => 'disabled',
            ),
            'automatically_check' => array(
                'title' => __('Automatically check', 'cashback-tracker'),
                'description' => __('Select how often to download orders from affiliate networks.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    '0.' => __('Never', 'cashback-tracker'),
                    '3600.' => __('Every hour', 'cashback-tracker'),
                    '7200.' => __('Every two hours', 'cashback-tracker'),
                    '21600.' => __('Every six hours', 'cashback-tracker'),
                    '43200.' => __('Every twelve hours', 'cashback-tracker'),
                    '86400.' => __('Every day', 'cashback-tracker'),
                ),
                'default' => '3600.',
            ),
            'log_target_email' => array(
                'title' => __('Email alerts', 'cashback-tracker'),
                'description' => __('This options allows you to specify which types of alerts you want to receive to admin email.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'error' => __('Errors only', 'cashback-tracker'),
                    'warning_error' => __('Warnings and Errors only', 'cashback-tracker'),
                    'all' => __('All', 'cashback-tracker'),
                    'none' => __('None', 'cashback-tracker'),
                ),
                'default' => 'error',
            ),
            'log_target_db' => array(
                'title' => __('Log alerts', 'cashback-tracker'),
                'description' => __('This options allows you to specify which types of alerts you want to log to DB.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'all' => __('All', 'cashback-tracker'),
                    'all_without_debug' => __('All without debug', 'cashback-tracker'),
                ),
                'default' => 'all_without_debug',
            ),
            'from_name' => array(
                'title' => __('From Name', 'cashback-tracker'),
                'description' => __('This name will appear in the From Name column of emails sent from the plugin.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    'allow_empty',
                ),
            ),
            'from_email' => array(
                'title' => __('From Email', 'cashback-tracker'),
                'description' => __('Customize the From Email address.', 'cashback-tracker') . ' ' . __('To avoid your email being marked as spam, it is recommended your "from" match your website.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    'allow_empty',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'valid_email'),
                        'message' => sprintf(__('Field "%s" filled with wrong data.', 'cashback-tracker'), 'From Email'),
                    ),
                ),
            ),
            'main_color' => array(
                'title' => __('Main color', 'cashback-tracker'),
                'description' => __('This color will be used for some graphic elements on frontend part.', 'cashback-tracker'),
                'callback' => array($this, 'render_color_picker'),
                'default' => '#FB7F36',
                'validator' => array(
                    'trim',
                ),
            ),
            'advertiser_page_status' => array(
                'title' => __('Status of advertiser page', 'cashback-tracker'),
                'description' => __('Default status for automatically generated pages.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'publish' => __('Publish', 'cashback-tracker'),
                    'pending' => __('Pending', 'cashback-tracker'),
                ),
                'default' => 'publish',
            ),
            'advertiser_page_title' => array(
                'title' => __('Title of advertiser page', 'cashback-tracker'),
                'description' => __('Default title for automatically generated pages.', 'cashback-tracker') . ' ' .
                    sprintf(__('You can use tags: %s.', 'cashback-tracker'), '%NAME%, %DOMAIN%, %CASHBACK%'),
                'callback' => array($this, 'render_input'),
                'default' => '%NAME% Cashback',
                'validator' => array(
                    'trim',
                    'allow_empty',
                ),
            ),
            'cashback_section' => array(
                'title' => __('Cashback section', 'cashback-tracker'),
                'description' => __('Hide the cashback section on the Cashback stores page.', 'cashback-tracker') . ' ' .
                    __('You can use this option to create a coupon website without cashback features.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'enabled' => __('Enabled', 'cashback-tracker'),
                    'disabled' => __('Disabled', 'cashback-tracker'),
                ),
                'default' => 'enabled',
            ),
            'dequeue_style' => array(
                'title' => __('Plugin CSS', 'cashback-tracker'),
                'description' => __('Dequeue plugin style.', 'cashback-tracker') .
                    '<p class="description">' . __('You can disable default CSS if you use your own custom templates and styles.', 'cashback-tracker') . '</p>',
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'registration_url' => array(
                'title' => __('Registration URL', 'cashback-tracker'),
                'description' => __('Add custom link if you want to use custom register page for "Go to shop" button.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    'allow_empty',
                ),
            ),
            'gotoshop_button_class' => array(
                'title' => __('"Go to shop" button class', 'cashback-tracker'),
                'description' => __('Add custom class to "Go to shop" button. In this way, you can trigger login popup if your theme supports such feature.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    '\sanitize_html_class',
                ),
            ),
            'force_author_id' => array(
                'title' => __('Author ID', 'cashback-tracker'),
                'description' => __('Use Author ID instead of User ID in tracking links.', 'cashback-tracker') .
                    '<p class="description">' .
                    __('In some cases, you may need to give commission to author of post and not to users.', 'cashback-tracker') .
                    ' ' . sprintf(__('Read more <a target="_bklanl" href="%s">here</a>.', 'cashback-tracker'), 'https://ctracker-docs.keywordrush.com/how-to/how-to-give-commission-to-author') .
                    '</p>',
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'woo_tracking' => array(
                'title' => __('WooCommerce tracking', 'cashback-tracker'),
                'description' => __('Convert all WooCommerce external links to tracking links automatically.', 'cashback-tracker'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
            'woo_cashback_notice' => array(
                'title' => __('WooCommerce notice', 'cashback-tracker'),
                'description' => __('Show cashback notice for WooCommerce products.', 'cashback-tracker'),
                'callback' => array($this, 'render_checkbox'),
                'default' => false,
                'section' => 'default',
            ),
        );
    }

    public function settings_page()
    {
        PluginAdmin::getInstance()->render('settings', array('page_slug' => $this->page_slug()));
    }
}
