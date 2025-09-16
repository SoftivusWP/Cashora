<?php

namespace CashbackTracker\application\modules\Pepperjam;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CashbackmoduleConfig;

/**
 * PepperjamConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class PepperjamConfig extends CashbackmoduleConfig
{

    public function options()
    {
        $options = array(
            'api_key' => array(
                'title' => 'API Key' . ' <span class="cbtrkr_required">*</span>',
                'description' => '<a target="_blank" href="https://www.pepperjamnetwork.com/affiliate/api/">' . __('Generate API key', 'cashback-tracker'),
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
            'website_id' => array(
                'title' => 'Website ID' . ' <span class="cbtrkr_required">*</span>',
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
            'locked_status' => array(
                'title' => __('Locked status', 'cashback-tracker'),
                'description' => __('Applay the selected status for "locked" orders.', 'cashback-tracker'),
                'callback' => array($this, 'render_dropdown'),
                'dropdown_options' => array(
                    'approved' => __('Apply Approved status', 'cashback-tracker'),
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
