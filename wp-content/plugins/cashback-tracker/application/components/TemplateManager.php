<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\admin\GeneralConfig;
use CashbackTracker\application\admin\CouponConfig;

/**
 * TemplateManager class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class TemplateManager
{

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;

        return self::$instance;
    }

    public static function getTempateDir()
    {
        return \CashbackTracker\PLUGIN_PATH . 'templates/';
    }

    public function render($view_name, array $_data = array())
    {
        if (!$file = $this->getViewPath($view_name))
            return '';

        extract($_data, EXTR_PREFIX_SAME, 'data');

        ob_start();
        ob_implicit_flush(false);
        include $file;
        $res = ob_get_clean();
        return $res;
    }

    public function getViewPath($view_name)
    {
        $view_name = str_replace('.', '', $view_name);
        $file_name = $view_name . '.php';

        if ($template = \locate_template($file_name))
            $file = $template;
        else
            $file = self::getTempateDir() . $file_name;

        if (is_file($file) && is_readable($file))
            return $file;
        else
            return false;
    }

    public function isTemplateExists($view_name)
    {
        $file = $this->getViewPath($view_name);
        if (!$file)
            return false;
        else
            return true;
    }

    public function enqueueFrontendStyle()
    {
        \wp_enqueue_style('cbtrkr-frontend');
        $color = \esc_attr(GeneralConfig::getInstance()->option('main_color'));
        $coupon_color = \esc_attr(CouponConfig::getInstance()->option('button_color'));
        $custom_css = "a.cbtrkr_grid_item:hover{border-color:" . $color . ";}.cbtrkr_listing_orange_color,.cbtrkr_grid_cashback{color: " . $color . ";} .cbtrkr_return{background-color: " . $color . ";}.cbtrkr_cashback_notice_merchant{color: " . $color . ";}a.cbtrkr_btn_goshop{background-color: " . $color . ";}";
        $custom_css .= ".cbtrkr_coupon_btn_deal,.cbtrkr_coupon_btn_txt{background:" . $coupon_color . ";}.cbtrkr_coupon_btn_txt:before{border-top: 42px solid " . $coupon_color . "}.cbtrkr_coupon_hidden_code{border-color:" . $coupon_color . ";}";

        \wp_add_inline_style('cbtrkr-frontend', $custom_css);
    }

    public function enqueueFrontendScript()
    {
        \wp_enqueue_script('cbtrkr-frontend');
    }
}
