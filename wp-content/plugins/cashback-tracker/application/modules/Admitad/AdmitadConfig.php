<?php

namespace CashbackTracker\application\modules\Admitad;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;
use CashbackTracker\application\Plugin;

/**
 * AdmitadConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AdmitadConfig extends CashbackmoduleConfig
{

    public function options()
    {
        $options = array(
            'client_id' => array(
                'title' => 'Client ID' . ' <span class="cbtrkr_required">*</span>',
                'description' => sprintf(__('Your <a target="_blank" href="%s">Admitad</a> Client ID.', 'cashback-tracker'), 'https://www.keywordrush.com/go/admitad'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Client ID'),
                    ),
                ),
            ),
            'client_secret' => array(
                'title' => 'Client Secret' . ' <span class="cbtrkr_required">*</span>',
                'description' => sprintf(__('Your <a target="_blank" href="%s">Admitad</a> Client Secret.', 'cashback-tracker'), 'https://www.keywordrush.com/go/admitad'),
                'callback' => array($this, 'render_password'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Client Secret'),
                    ),
                ),
            ),
            'website_id' => array(
                'title' => 'Website ID' . ' <span class="cbtrkr_required">*</span>',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Website ID'),
                    ),
                ),
            ),
            'approved_but_stalled' => array(
                'title' => __('Approved but stalled', 'cashback-tracker'),
                'description' => __('Applay the selected status for "Approved but stalled" orders.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'approved' => __('Apply Approved status', 'cashback-tracker'),
                    'pending' => __('Apply Pending status', 'cashback-tracker'),
                ),
                'default' => 'approved',
            ),
            'region' => array(
                'title' => __('Sales region', 'cashback-tracker'),
                'description' => __('This parameter is used to filter coupons. Expects the two-letter ISO 3166 country code. Leave this field empty to import all coupons.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                ),
            ),
        );
        $options = array_merge($options, parent::options());
        $options = array('is_active' => $options['is_active']) + $options;
        return $options;
    }

    public function validate($input)
    {
        $transient_name = Plugin::slug() . '-' . 'Admitad' . '-access_token';
        \delete_transient($transient_name);
        return parent::validate($input);
    }
}
