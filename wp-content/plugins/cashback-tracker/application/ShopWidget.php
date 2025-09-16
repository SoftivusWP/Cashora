<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\components\CtWidget;

/**
 * ShopWidget class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ShopWidget extends CtWidget
{

    public function slug()
    {
        return 'cbtrkr_shops';
    }

    public function description()
    {
        return __('Cashback shops', 'cashback-tracker');
    }

    protected function name()
    {
        return __('CTracker: Shops', 'cashback-tracker');
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
                    'default' => 'Top Stores',
                    'title' => __('Title', 'cashback-tracker'),
                ),
                'limit' => array(
                    'type' => 'number',
                    'min' => 1,
                    'max' => 60,
                    'default' => 6,
                    'title' => __('Number of shops to show', 'cashback-tracker'),
                ),
                'orderby' => array(
                    'type' => 'select',
                    'default' => '',
                    'title' => __('Sort', 'cashback-tracker'),
                    'options' => array(
                        '' => __('Default', 'cashback-tracker'),
                        'date' => __('date', 'cashback-tracker'),
                        'ID' => __('ID date', 'cashback-tracker'),
                        'modified' => __('modified', 'cashback-tracker'),
                        'name' => __('name', 'cashback-tracker'),
                        'rand' => __('rand', 'cashback-tracker'),
                        'title' => __('title', 'cashback-tracker'),
                        'comment_count' => __('comment_count', 'cashback-tracker'),
                    )
                ),
                'order' => array(
                    'type' => 'select',
                    'default' => 'DESC',
                    'title' => __('Order', 'cashback-tracker'),
                    'options' => array(
                        'ASC' => __('Ascending', 'cashback-tracker'),
                        'DESC' => __('Descending', 'cashback-tracker'),
                    )
                ),
                'include' => array(
                    'type' => 'text',
                    'default' => "",
                    'title' => __('Include', 'cashback-tracker') . ' (' . __('shop page IDs separated by commas', 'cashback-tracker') . ')',
                ),
                'exclude' => array(
                    'type' => 'text',
                    'default' => "",
                    'title' => __('Exclude', 'cashback-tracker') . ' (' . __('shop page IDs separated by commas', 'cashback-tracker') . ')',
                ),
                'cols' => array(
                    'type' => 'select',
                    'default' => '3',
                    'title' => __('Columns', 'cashback-tracker'),
                    'options' => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                        '6' => '6',
                    )
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

        $params[] = 'type="widget"';
        echo \do_shortcode('[cashback-shops ' . join(' ', $params) . ']');

        $this->afterWidget($args, $instance);
    }
}
