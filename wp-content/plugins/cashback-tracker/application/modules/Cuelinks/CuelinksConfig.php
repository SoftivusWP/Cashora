<?php

namespace CashbackTracker\application\modules\Cuelinks;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;

/**
 * CuelinksConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CuelinksConfig extends CashbackmoduleConfig
{

    public function options()
    {
        $options = array(
            'api_key' => array(
                'title' => 'API key <span class="cbtrkr_required">*</span>',
                'description' => __('Cuelinks uses a custom header containing an API key to identify your requests.', 'cashback-tracker') . ' ' . sprintf(__('Request for an API Key at %s.', 'cashback-tracker'), 'sales@cuelinks.com'),
                'callback' => array($this, 'render_password'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'API key'),
                    ),
                ),
            ),
            'channel_id' => array(
                'title' => 'Channel ID <span class="cbtrkr_required">*</span>',
                'description' => __('Go to your CueLinks dashboard - Account - My Channels and find your Channel ID.', 'cashback-tracker'),
                'callback' => array($this, 'render_input'),
                'default' => '',
                'validator' => array(
                    'trim',
                    array(
                        'call' => array('\CashbackTracker\application\helpers\FormValidator', 'required'),
                        'when' => 'is_active',
                        'message' => sprintf(__('The field "%s" can not be empty.', 'cashback-tracker'), 'Channel ID'),
                    ),
                ),
            ),
            'validated_status' => array(
                'title' => __('Validated orders', 'cashback-tracker'),
                'description' => __('Applay the selected status for "Validated" orders.', 'cashback-tracker') . ' ' . sprintf(__('<a target="_blank" href="%s">Read more...</a>', 'cashback-tracker'), 'https://desk.zoho.com/portal/cuelinks/en/kb/articles/what-are-the-various-validation-parameters'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'approved' => __('Apply Approved status', 'cashback-tracker'),
                    'pending' => __('Apply Pending status', 'cashback-tracker'),
                ),
                'default' => 'approved',
            ),
        );
        $options = array_merge($options, parent::options());
        $options = array('is_active' => $options['is_active']) + $options;
        return $options;
    }
}
