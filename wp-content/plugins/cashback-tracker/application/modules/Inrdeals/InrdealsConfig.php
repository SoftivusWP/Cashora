<?php

namespace CashbackTracker\application\modules\Inrdeals;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;

/**
 * InrdealsConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class InrdealsConfig extends CashbackmoduleConfig
{

    public function options()
    {
        $options = array(
            'token_store' => array(
                'title' => 'Token for Store API' . ' <span class="cbtrkr_required">*</span>',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Token for Store API'),
                    ),
                ),
            ),
            'token_coupon' => array(
                'title' => 'Token for Coupon Feed' . ' <span class="cbtrkr_required">*</span>',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Token for Coupon Feed'),
                    ),
                ),
            ),
            'token_transaction' => array(
                'title' => 'Token for Transaction API' . ' <span class="cbtrkr_required">*</span>',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Token for Transaction API'),
                    ),
                ),
            ),
            'id' => array(
                'title' => 'INRDeals username' . ' <span class="cbtrkr_required">*</span>',
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'INRDeals username'),
                    ),
                ),
            ),
        );
        $options = array_merge($options, parent::options());
        $options = array('is_active' => $options['is_active']) + $options;
        return $options;
    }
}
