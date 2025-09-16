<?php

namespace CashbackTracker\application\modules\Impact;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;

/**
 * ImpactConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ImpactConfig extends CashbackmoduleConfig
{

    public function options()
    {
        $options = array(
            'sid' => array(
                'title' => 'Account SID' . ' <span class="cbtrkr_required">*</span>',
                'description' => sprintf(__('You can view and manage your API keys in the <a target="_blank" href="%s">impact.com platform</a>.', 'cashback-tracker'), 'https://app.impact.com/secure/mediapartner/accountSettings/mp-wsapi-flow.ihtml'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Account SID'),
                    ),
                ),
            ),
            'token' => array(
                'title' => 'Auth Token' . ' <span class="cbtrkr_required">*</span>',
                'description' => sprintf(__('You can view and manage your API keys in the <a target="_blank" href="%s">impact.com platform</a>.', 'cashback-tracker'), 'https://app.impact.com/secure/mediapartner/accountSettings/mp-wsapi-flow.ihtml'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Auth Token'),
                    ),
                ),
            ),
            'currency' => array(
                'title' => 'Default curency',
                'description' => __('Expected currency format is the ISO 4217 currency code (i.e. USD, EUR etc.)', 'cashback-tracker'),
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
