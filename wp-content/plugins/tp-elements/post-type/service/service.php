<?php
class Pixelaxis_Service_Post_Type{	

	public function __construct() {
		add_action( 'init', array( $this, 'tp_service_register_post_type' ) );		
		add_action( 'init', array( $this, 'tp_create_service_category' ) );
	}

	// Register Service Post Type
	function tp_service_register_post_type() {
		$labels = array(
			'name'               => esc_html__( 'Service', 'tp-elements'),
			'singular_name'      => esc_html__( 'Service', 'tp-elements'),
			'add_new'            => esc_html_x( 'Add New Service', 'tp-elements'),
			'add_new_item'       => esc_html__( 'Add New Service', 'tp-elements'),
			'edit_item'          => esc_html__( 'Edit Service', 'tp-elements'),
			'new_item'           => esc_html__( 'New Service', 'tp-elements'),
			'all_items'          => esc_html__( 'All Service', 'tp-elements'),
			'view_item'          => esc_html__( 'View Service', 'tp-elements'),
			'search_items'       => esc_html__( 'Search Service', 'tp-elements'),
			'not_found'          => esc_html__( 'No Service found', 'tp-elements'),
			'not_found_in_trash' => esc_html__( 'No Service found in Trash', 'tp-elements'),
			'parent_item_colon'  => esc_html__( 'Parent Service:', 'tp-elements'),
			'menu_name'          => esc_html__( 'Service', 'tp-elements'),
		);
		global $cashora_option;
	   	$service_slug = (!empty($cashora_option['service_slug']))? $cashora_option['service_slug'] :'services';
		$args = array(
			'labels'             => $labels,
			'public'             => true,	
			'show_in_menu'       => true,
			'show_in_admin_bar'  => true,
			'can_export'         => true,
			'has_archive'        => true,
			'hierarchical'       => true,
			'menu_position'      => 20,		
			'rewrite' => 		 array('slug' => $service_slug,'with_front' => false),
			'menu_icon'          =>  plugins_url( 'img/icon.png', __FILE__ ),
			'supports'           => array( 'title', 'thumbnail','editor', 'excerpt'),		
		);
		register_post_type( 'services', $args );
	}

	function tp_create_service_category() {
		
		register_taxonomy(
			'service-category',
			'services',
			array(
				'label' => esc_html__( 'Service Categories','tp-elements'),			
				'hierarchical' => true,
				'show_admin_column' => true,
			)
		);
	}


}
new Pixelaxis_Service_Post_Type();