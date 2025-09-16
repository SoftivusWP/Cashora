<?php

namespace CashbackTracker\application\components;

defined('\ABSPATH') || exit;

/**
 * ShopTaxonomy class file
 *
 * @author keywordrush.com <support@keywordrush.com>
 * @link https://www.keywordrush.com
 * @copyright Copyright &copy; 2025 keywordrush.com
 */
class ShopTaxonomy
{
    public static function init()
    {
        \add_action('init', array(__CLASS__, 'registerTaxonomy'), 0);
    }

    public static function registerTaxonomy()
    {
        $labels = array(
            'name' => _x('Shop categories', 'Taxonomy General Name', 'cashback-tracker'),
            'singular_name' => _x('Category', 'Taxonomy Singular Name', 'cashback-tracker'),
            'menu_name' => __('Shop categories', 'cashback-tracker'),
            'all_items' => __('All Categories', 'cashback-tracker'),
            'parent_item' => __('Parent Item', 'cashback-tracker'),
            'parent_item_colon' => __('Parent Item:', 'cashback-tracker'),
            'new_item_name' => __('New Item Name', 'cashback-tracker'),
            'add_new_item' => __('Add New Item', 'cashback-tracker'),
            'edit_item' => __('Edit Item', 'cashback-tracker'),
            'update_item' => __('Update Item', 'cashback-tracker'),
            'view_item' => __('View Item', 'cashback-tracker'),
            'separate_items_with_commas' => __('Separate items with commas', 'cashback-tracker'),
            'add_or_remove_items' => __('Add or remove items', 'cashback-tracker'),
            'choose_from_most_used' => __('Choose from the most used', 'cashback-tracker'),
            'popular_items' => __('Popular Items', 'cashback-tracker'),
            'search_items' => __('Search Items', 'cashback-tracker'),
            'not_found' => __('Not Found', 'cashback-tracker'),
            'items_list' => __('Items list', 'cashback-tracker'),
            'items_list_navigation' => __('Items list navigation', 'cashback-tracker'),
        );
        $rewrite = array(
            'slug' => 'shop-category',
            'with_front' => true,
            'hierarchical' => false,
        );
        $args = array(
            'labels' => $labels,
            'hierarchical' => true,
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => false,
            'rewrite' => $rewrite,
        );
        \register_taxonomy('cbtrkr_shop_category', array('cbtrkr_shop'), $args);
    }
}
