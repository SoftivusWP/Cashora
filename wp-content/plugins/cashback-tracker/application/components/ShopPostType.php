<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

/**
 * ShopPostType class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ShopPostType
{
    const SLUG = 'shops';

    public static function init()
    {
        \add_action('init', array(__CLASS__, 'registerPostType'), 0);
    }

    public static function registerPostType()
    {
        $labels = array(
            'name' => _x('Cashback shops', 'post type general name', 'cashback-tracker'),
            'singular_name' => _x('Cashback shop', 'post type singular name', 'cashback-tracker'),
            'menu_name' => _x('Cashback shops', 'admin menu', 'cashback-tracker'),
            'name_admin_bar' => _x('Cashback shop', 'add new on admin bar', 'cashback-tracker'),
            'add_new' => _x('Add New', 'book', 'cashback-tracker'),
            'add_new_item' => __('Add New Shop', 'cashback-tracker'),
            'new_item' => __('New Shop', 'cashback-tracker'),
            'edit_item' => __('Edit Shop', 'cashback-tracker'),
            'view_item' => __('View Shop', 'cashback-tracker'),
            'all_items' => __('All shops', 'cashback-tracker'),
            'search_items' => __('Search shops', 'cashback-tracker'),
            'not_found' => __('No cashback shops found.', 'cashback-tracker'),
            'not_found_in_trash' => __('No cashback shops found in Trash.', 'cashback-tracker')
        );

        $labels = \apply_filters('cbtrkr_shops_labels', $labels);

        $args = array(
            'labels' => $labels,
            'rewrite' => array('slug' => \apply_filters('cbtrkr_shops_slug', self::SLUG)),
            'description' => __('Cashback shops', 'cashback-tracker'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail', 'comments', 'custom-fields'),
            'taxonomies' => array('cbtrkr_shop'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => true,
            'show_in_admin_bar' => true,
            'menu_position' => 5,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
        );
        \register_post_type('cbtrkr_shop', $args);
    }
}
