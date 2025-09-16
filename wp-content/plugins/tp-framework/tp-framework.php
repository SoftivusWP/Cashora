<?php
/**
* Plugin Name: TP Framework
* Plugin URI: https://codecanyon.net/user/pixelaxis
* Description: Custom Framework plugin for page metabox
* Version: 1.0.0
* Author: Pixelaxis
* Author URI: http://www.softivus.com
*/

// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die( 'You should not be here' );
}

/**
* Function when plugin is activated
*
* @param void
*
*/
//Including file that manages all template

//All Post type include here

$dir = plugin_dir_path( __FILE__ );
//For team
require_once $dir .'/metaboxes/page-header.php';
require_once $dir .'/metaboxes/custom-metabox.php';
require_once $dir .'/metaboxes/cmb2/init.php';

/**
 * Implement widgets
 */
require_once $dir . '/widgets/post_recent_widget.php';
require_once $dir . '/widgets/contact.php';
require_once $dir . '/widgets/social-icon.php';
require_once $dir . '/widgets/product-categories.php';
require_once $dir . '/widgets/tp-posts-categories.php';
require_once $dir . '/widgets/serivice-tags.php';
require_once $dir . '/widgets/search_widget.php';
require_once $dir . '/widgets/bookinfo.php';

// function pixelaxis_food_materials() {	
// 	register_taxonomy(
// 		'food-materials',
// 		'product',
// 		array(
// 			'label' => esc_html__( 'Food Materials', 'tp-framework'),			
// 			'hierarchical' => true,
// 			'show_admin_column' => true,		
// 		)
// 	);
// }
// add_action( 'init', 'pixelaxis_food_materials' );