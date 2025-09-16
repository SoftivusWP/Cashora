<?php

namespace CashbackTracker\application\modules\Demo;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;
use CashbackTracker\application\helpers\CurrencyHelper;

/**
 * DemoConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link httpы://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class DemoConfig extends CashbackmoduleConfig
{

    public function options()
    {
        $options = array(
            'currency' => array(
                'title' => __('Demo currency', 'cashback-tracker'),
                'description' => '',
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array_combine(CurrencyHelper::getCurrenciesList(), CurrencyHelper::getCurrenciesList()),
                'default' => 'USD',
            ),
            'username' => array(
                'title' => __('Username', 'cashback-tracker'),
                'description' => __('Add orders for this user. Current user or administrator username will be used by default.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    'allow_empty',
                ),
            ),
        );
        $options = array_merge($options, parent::options());
        $options = array('is_active' => $options['is_active']) + $options;
        return $options;
    }
}
