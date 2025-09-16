<?php

namespace CashbackTracker\application\modules\Cj;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;

/**
 * CjConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CjConfig extends CashbackmoduleConfig
{

    public function options()
    {
        $options = array(
            'access_token' => array(
                'title' => 'Personal access token <span class="cbtrkr_required">*</span>',
                'description' => __('A Personal Access Token is a unique identification string for your account.', 'cashback-tracker') . ' ' . sprintf(__('You can get it <a target="_blank" href="%s">here</a>.', 'cashback-tracker'), 'https://developers.cj.com/account/personal-access-tokens'),
                'callback' => array($this, 'render_password'),
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
            'cid' => array(
                'title' => 'Company ID <span class="cbtrkr_required">*</span>',
                'description' => __('CID or Company ID is your account number. This number is located on the top right side of your screen next to your name.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field  "%s" can not be empty', 'cashback-tracker'), 'Company ID'),
                    ),
                ),
            ),
            'website_id' => array(
                'title' => 'Website ID <span class="cbtrkr_required">*</span>',
                'description' => __('PID, also known as your Publisher Website ID. To find your PID, navigate to your Account tab -> Site Settings.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field  "%s" can not be empty', 'cashback-tracker'), 'Website ID'),
                    ),
                ),
            ),
            'locked_status' => array(
                'title' => __('Locked orders', 'cashback-tracker'),
                'description' => __('Applay the selected status for "Loked" orders.', 'cashback-tracker')
                    . ' ' . __('In the standard transaction lifecycle, transactions lock at 2am PST on the 11th of each month. Once a transaction has a status of locked, advertiser can no longer correct or extend it - it has moved into the publisher payout cycle.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'approved' => __('Apply Approved status', 'cashback-tracker'),
                    'pending' => __('Apply Pending status', 'cashback-tracker'),
                ),
                'default' => 'pending',
            ),
            'pub_currency' => array(
                'title' => __('Publisher currency', 'cashback-tracker'),
                'description' => __('Enable this option if your publisher payout currency differs from USD and you wish to accrue cashback in your publisher payout currency. If not enabled, cashback will be accrued in USD. For instance, you can set it to EUR.', 'cashback-tracker'),
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
}
