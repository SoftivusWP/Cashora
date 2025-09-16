<?php

namespace CashbackTracker\application;

defined('\ABSPATH') || exit;

use CashbackTracker\application\helpers\TextHelper;
use CashbackTracker\application\components\TemplateManager;

/**
 * ShopsShortcode class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ShopsShortcode
{

    const SLUG = 'cashback-shops';

    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance == null)
            self::$instance = new self;
        return self::$instance;
    }

    private function __construct()
    {
        \add_shortcode(self::getSlug(), array($this, 'shops'));
        \add_filter('term_description', 'shortcode_unautop');
        \add_filter('term_description', 'do_shortcode');
    }

    static public function getSlug()
    {
        return \apply_filters('cbtrkr_advertisers_shortcode', self::SLUG);
    }

    private function prepareAttr($atts)
    {
        $a = \shortcode_atts(array(
            'cols' => 5,
            'limit' => 10,
            'orderby' => '',
            'order' => '',
            'include' => '',
            'exclude' => '',
            'imageheight' => 60,
            'wrapclass' => 'cbtrkr_merchants_wrap',
            'classitem' => '',
            'type' => 'grid',
            'template' => '',
        ), $atts);

        if (!$a['cols'] = absint($a['cols']))
            $a['cols'] = 5;
        if (!$a['limit'] = absint($a['limit']))
            $a['limit'] = 10;
        if (!$a['imageheight'] = absint($a['imageheight']))
            $a['imageheight'] = 60;
        $a['orderby'] = \sanitize_text_field($a['orderby']);
        $a['order'] = strtoupper(\sanitize_text_field($a['order']));
        $a['wrapclass'] = \sanitize_text_field(\wp_strip_all_tags($a['wrapclass']));
        $a['classitem'] = \sanitize_text_field(\wp_strip_all_tags($a['classitem']));
        $a['type'] = TextHelper::clear($a['type']);
        $a['template'] = TextHelper::clear($a['template']);
        if ($a['template'] && !$a['type'])
            $a['type'] = $a['template'];
        if (!in_array($a['orderby'], array('date', 'ID', 'modified', 'name', 'rand', 'title', 'comment_count')))
            $a['orderby'] = 'date';
        if (!in_array($a['order'], array('ASC', 'DESC')))
            $a['order'] = 'DESC';

        $a['include'] = TextHelper::commaListToIntArray($a['include']);
        $a['exclude'] = TextHelper::commaListToIntArray($a['exclude']);

        return $a;
    }

    public function shops($atts, $content = '')
    {
        $a = $this->prepareAttr($atts);
        $args = array(
            'post_type' => 'cbtrkr_shop',
            'post_status' => 'publish',
            'suppress_filters' => true,
            'posts_per_page' => $a['limit'],
            'orderby' => $a['orderby'],
            'order' => $a['order']
        );
        if ($a['include'])
            $args['include'] = $a['include'];
        if ($a['exclude'])
            $args['exclude'] = $a['exclude'];

        if (!$shop_pages = \get_posts($args))
            return '';

        $data = array(
            'shop_pages' => $shop_pages,
            'a' => $a,
        );

        if ($a['type'] == 'grid')
            $template = 'cashback-shops-grid';
        elseif ($a['type'] == 'alphabet')
            $template = 'cashback-shops-alphabet';
        elseif ($a['type'] == 'widget')
            $template = 'cashback-shops-widget';
        else
            return '';

        return TemplateManager::getInstance()->render($template, $data);
    }
}
