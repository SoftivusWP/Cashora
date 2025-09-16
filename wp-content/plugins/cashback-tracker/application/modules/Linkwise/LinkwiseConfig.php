<?php

namespace CashbackTracker\application\modules\Linkwise;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;

/**
 * LinkwiseConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class LinkwiseConfig extends CashbackmoduleConfig
{

    public function options()
    {
        $options = array(
            'username' => array(
                'title' => 'API Username' . ' <span class="cbtrkr_required">*</span>',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'API Username'),
                    ),
                ),
            ),
            'password' => array(
                'title' => 'API Password' . ' <span class="cbtrkr_required">*</span>',
                'callback' => array($this, 'render_password'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'API Password'),
                    ),
                ),
            ),
            'affiliate_id' => array(
                'title' => 'Affiliate ID' . ' <span class="cbtrkr_required">*</span>',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Affiliate ID'),
                    ),
                ),
            ),

            'pending_validated' => array(
                'title' => __('Pending validated', 'cashback-tracker'),
                'description' => __('Applay the selected status for "pending_validated" orders.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'validated' => __('Apply Validated status', 'cashback-tracker'),
                    'pending' => __('Apply Pending status', 'cashback-tracker'),
                ),
                'default' => 'pending',
            ),


        );
        $options = array_merge($options, parent::options());
        $options = array('is_active' => $options['is_active']) + $options;
        return $options;
    }
}
