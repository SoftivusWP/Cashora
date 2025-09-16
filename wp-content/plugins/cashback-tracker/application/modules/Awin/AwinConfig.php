<?php

namespace CashbackTracker\application\modules\Awin;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;

/**
 * AwinConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class AwinConfig extends CashbackmoduleConfig
{
    public function options()
    {
        $options = array(
            'publisherId' => array(
                'title' => 'Publisher ID' . ' <span class="cbtrkr_required">*</span>',
                'description' => __('Your publisher ID.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Publisher ID'),
                    ),
                ),
            ),
            'accessToken' => array(
                'title' => 'Access Token' . ' <span class="cbtrkr_required">*</span>',
                'description' => sprintf(__('Your can find your Access Token <a target="_blank" href="%s">here</a>.', 'cashback-tracker'), 'https://ui.awin.com/awin-api'),
                'callback' => array($this, 'render_password'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Access Token'),
                    ),
                ),
            ),
        );

        $options = array_merge($options, parent::options());
        $options = array('is_active' => $options['is_active']) + $options;

        return $options;
    }
}
