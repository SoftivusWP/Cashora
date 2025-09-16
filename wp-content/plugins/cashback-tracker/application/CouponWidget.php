<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CtWidget;

/**
 * CouponWidget class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class CouponWidget extends CtWidget
{

    public function slug()
    {
        return 'cbtrkr_coupons';
    }

    public function description()
    {
        return __('Coupons and deals', 'cashback-tracker');
    }

    protected function name()
    {
        return __('CTracker: Coupons', 'cashback-tracker');
    }

    public function classname()
    {
        return 'widget cbtrkr_widget';
    }

    public function settings()
    {
        return
            array(
                'title' => array(
                    'type' => 'text',
                    'default' => 'Top Offers',
                    'title' => __('Title', 'cashback-tracker'),
                ),
                'limit' => array(
                    'type' => 'number',
                    'min' => 1,
                    'max' => 30,
                    'default' => 5,
                    'title' => __('Number of coupons to show', 'cashback-tracker'),
                ),
                'sort' => array(
                    'type' => 'select',
                    'default' => '',
                    'title' => __('Sort', 'cashback-tracker'),
                    'options' => array(
                        '' => __('Default', 'cashback-tracker'),
                        'start_date' => __('Start date', 'cashback-tracker'),
                        'end_date' => __('End date', 'cashback-tracker'),
                        'title' => __('Title', 'cashback-tracker'),
                        'discount' => __('Discount', 'cashback-tracker') . ' (Admitad only)',
                    )
                ),
                'order' => array(
                    'type' => 'select',
                    'default' => 'asc',
                    'title' => __('Order', 'cashback-tracker'),
                    'options' => array(
                        'asc' => __('Ascending', 'cashback-tracker'),
                        'desc' => __('Descending', 'cashback-tracker'),
                    )
                ),
                'type' => array(
                    'type' => 'select',
                    'default' => '',
                    'title' => __('Type', 'cashback-tracker'),
                    'options' => array(
                        '' => __('All', 'cashback-tracker'),
                        'coupon' => __('Coupons', 'cashback-tracker'),
                        'deal' => __('Deals', 'cashback-tracker'),
                    )
                ),
                'advertiser_ids' => array(
                    'type' => 'text',
                    'default' => "",
                    'title' => __('List of advertiser IDs or domains separated by commas', 'cashback-tracker'),
                ),
            );
    }

    /**
     * Front-end display of widget.
     */
    public function widget($args, $instance)
    {

        $this->beforeWidget($args, $instance);

        $params = array();

        foreach ($instance as $option => $value)
        {
            if ($option == 'title')
                continue;

            $value = str_replace('"', '', $value);

            if ($value)
                $params[] = $option . '="' . $value . '"';
        }

        $params[] = 'template="coupons-widget"';
        echo \do_shortcode('[cashback-coupons ' . join(' ', $params) . ']');

        $this->afterWidget($args, $instance);
    }
}
