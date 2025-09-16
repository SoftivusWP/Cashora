<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\ModuleConfig;
use CashbackTracker\application\helpers\CurrencyHelper;
use CashbackTracker\application\components\AdvertiserManager;

/**
 * CashbackmoduleConfig class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
abstract class CashbackmoduleConfig extends ModuleConfig
{

    public function options()
    {
        return array_merge(
            parent::options(),
            array(
                'is_active' => array(
                    'title' => __('Enable network', 'cashback-tracker'),
                    'description' => '',
                    'callback' => array($this, 'render_checkbox'),
                    'default' => 0,
                    'validator' => array(
                        array(
                            'call' => array($this, 'getAdvertisers'),
                        ),
                    ),
                ),

                'default_cashback' => array(
                    'title' => __('Default cashback', 'cashback-tracker'),
                    'callback' => array($this, 'render_commission_line'),
                    'default' => array(
                        0 => array('percent_type' => 'commission_amount', 'percentage_value' => 50)
                    ),
                    'validator' => array(),
                ),
                'cashback' => array(
                    'title' => __('Cashback by advertisers', 'cashback-tracker'),
                    'callback' => array($this, 'render_commission_block'),
                    'default' => array(),
                    'validator' => array(
                        array(
                            'call' => array($this, 'commissionFormat'),
                            'type' => 'filter',
                        ),
                        array(
                            'call' => array($this, 'getAdvertiser'),
                            'when' => 'is_active',
                        ),
                    ),
                )
            )
        );
    }

    public function render_commission_line($args)
    {
        if (isset($args['_field']))
            $i = $args['_field'];
        else
            $i = 0;

        $advertiser = null;
        $is_ative = ModuleManager::getInstance()->isModuleActive($this->getModuleId());
        if ($is_ative && isset($args['value'][$i]['advertiser_id']))
        {
            $advertiser_id = $args['value'][$i]['advertiser_id'];
            $advertiser = AdvertiserManager::getInstance()->getAdvertiser($this->getModuleId(), $advertiser_id);
        }
        elseif (isset($args['value'][$i]['advertiser_id']))
            $advertiser_id = $args['value'][$i]['advertiser_id'];
        else
            $advertiser_id = '';

        if (isset($args['value'][$i]['percentage_value']))
            $percentage_value = $args['value'][$i]['percentage_value'];
        else
            $percentage_value = '';

        if (isset($args['value'][$i]['percent_type']))
            $percent_type = $args['value'][$i]['percent_type'];
        else
            $percent_type = 'commission_amount';

        if (isset($args['value'][$i]['currency']))
            $currency = $args['value'][$i]['currency'];
        else
            $currency = 'USD';

        if ($args['name'] != 'default_cashback')
        {
            if ($advertiser && $advertiser['domain'])
                echo '<code>' . \esc_html($advertiser['domain']) . '</code><br />';
            elseif (isset($args['value'][$i]['advertiser_id']) && !$advertiser)
                echo '<code style="color: red;">' . __('not found', 'cashback-tracker') . '</code><br />';
            else
                echo '<code style="color: grey;">' . __('add new', 'cashback-tracker') . '</code><br />';

            echo '<input name="' . \esc_attr($args['option_name']) . '['
                . \esc_attr($args['name']) . '][' . $i . '][advertiser_id]" value="'
                . \esc_attr($advertiser_id) . '" class="text" placeholder="Advertiser ID"  type="number"/>';
        }

        echo '<select class="cbtrkr_percent_type" name="' . \esc_attr($args['option_name']) . '['
            . \esc_attr($args['name']) . '][' . $i . '][percent_type]">';
        echo '<option value="sale_amount"' . ($percent_type == 'sale_amount' ? ' selected="selected"' : '') . '>' . \esc_html(__('Percentage of sale amount', 'cashback-tracker')) . '</option>';
        echo '<option value="commission_amount"' . ($percent_type == 'commission_amount' ? ' selected="selected"' : '') . '>' . \esc_html(__('Percentage of my commission', 'cashback-tracker')) . '</option>';
        echo '<option value="flat_amount"' . ($percent_type == 'flat_amount' ? ' selected="selected"' : '') . '>' . \esc_html(__('Flat amount', 'cashback-tracker')) . '</option>';
        echo '</select>';

        echo '<input name="' . \esc_attr($args['option_name']) . '['
            . \esc_attr($args['name']) . '][' . $i . '][percentage_value]" value="'
            . \esc_attr($percentage_value) . '" class="cbtrkr_percentage_value" type="number" min="0" step="0.01" placeholder="Percentage Value" />';

        echo '<select' . ($percent_type != 'flat_amount' ? ' style="display:none;"' : '') . ' class="cbtrkr_currency" name="' . \esc_attr($args['option_name']) . '['
            . \esc_attr($args['name']) . '][' . $i . '][currency]">';
        foreach (CurrencyHelper::getCurrenciesList() as $c)
        {
            echo '<option value="' . \esc_attr($c) . '"' . ($c == $currency ? ' selected="selected"' : '') . '>' . \esc_html($c) . '</option>';
        }
        echo '</select>';
    }

    public function render_commission_block($args)
    {
        $total = count($args['value']) + 5;

        for ($i = 0; $i < $total; $i++)
        {
            echo '<div class="cbtrkr_commission_wrap" style="padding-bottom: 10px;">';
            $args['_field'] = $i;
            $this->render_commission_line($args);
            echo '</div>';
        }
        if ($args['description'])
            echo '<p class="description">' . $args['description'] . '</p>';
    }

    public function getAdvertisers($value)
    {
        if (!$value)
            return true;

        // request and cache advertiser list
        if (!AdvertiserManager::getInstance()->getDownloadDate($this->getModuleId()))
            AdvertiserManager::getInstance()->getAdvertisers($this->getModuleId(), $forced = true);

        return true;
    }

    public function getAdvertiser($values)
    {
        foreach ($values as $value)
        {
            // request and cache advertiser info
            AdvertiserManager::getInstance()->getAdvertiser($this->getModuleId(), $value['advertiser_id'], $forced = true);
        }
        return true;
    }

    public function commissionFormat($values)
    {
        $advertiser_ids = array();
        foreach ($values as $k => $value)
        {
            $values[$k]['advertiser_id'] = $value['advertiser_id'] = (int) $value['advertiser_id'];

            // copy from default
            if (trim($value['percentage_value']) === '')
            {
                if ($default = $this->option('default_cashback'))
                    $default = $default[0];
                if ($default && $default['percent_type'] == $value['percent_type'])
                {
                    $value['percentage_value'] = $default['percentage_value'];
                    $value['currency'] = $default['currency'];
                }
            }

            $values[$k]['percentage_value'] = $value['percentage_value'] = (float) $value['percentage_value'];
            if (!$value['advertiser_id'] || in_array($value['advertiser_id'], $advertiser_ids))
            {
                unset($values[$k]);
                continue;
            }
            $advertiser_ids[] = $value['advertiser_id'];
        }

        // reindex
        $values = array_values($values);
        return $values;
    }
}
